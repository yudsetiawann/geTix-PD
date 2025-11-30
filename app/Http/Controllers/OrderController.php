<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;

class OrderController extends Controller
{
    public function create(Event $event)
    {
        if ($event->ticket_quota <= 0) {
            return redirect()->route('events.show', $event)->with('error', 'Maaf, tiket untuk event ini sudah habis.');
        }
        return view('orders.create', [
            'event' => $event,
            'levelPrices' => $event->level_prices,
            'hasDynamicPricing' => $event->has_dynamic_pricing,
            'eventType' => $event->event_type,
        ]);
    }

    public function store(Request $request, Event $event, MidtransService $midtrans)
    {
        // 1. Validasi Input
        $baseRules = [
            'customer_name' => 'required|string|min:3',
            'phone_number'  => 'required|string|min:10',
            'school'        => 'required|string|min:3',
        ];

        $dynamicRules = [];
        $eventTypeLower = strtolower($event->event_type);

        // KOREKSI: Tambahkan validasi level untuk SEMUA tipe event (Ujian & Pertandingan)
        // Karena di blade Anda, dropdown 'level' selalu muncul.
        $dynamicRules['level'] = 'required|string';

        if ($eventTypeLower === 'pertandingan') {
            // Validasi data pribadi atlet
            $dynamicRules['nik']            = 'required|numeric|digits:16';
            $dynamicRules['kk']             = 'required|numeric|digits:16';
            $dynamicRules['birth_place']    = 'required|string';
            $dynamicRules['birth_date']     = 'required|date';
            $dynamicRules['weight']         = 'required|integer|min:10';

            // Validasi kategori pertandingan
            $dynamicRules['competition_level'] = 'required|string';
            $dynamicRules['category']          = 'required|string';

            if ($request->input('category') === 'Tanding') {
                $dynamicRules['class'] = 'required|string';
            }
        }

        $validated = $request->validate(array_merge($baseRules, $dynamicRules));

        // 2. Hitung Harga & Cek Kuota
        $quantity = 1;
        $levelForPrice    = $validated['level'] ?? null;
        $categoryForPrice = $validated['category'] ?? null;

        $pricePerTicket = $event->getPrice($levelForPrice, $categoryForPrice);

        if ($pricePerTicket === null) {
            return back()->withInput()->with('error', 'Kombinasi tingkatan/kategori tidak valid atau harga tidak ditemukan.');
        }

        $totalPrice = $pricePerTicket * $quantity;

        if ($event->ticket_quota < $quantity) {
            return back()->withInput()->with('error', 'Maaf, sisa kuota tiket tidak mencukupi.');
        }

        // 3. Proses Database & Midtrans
        try {
            $order = DB::transaction(function () use ($validated, $event, $midtrans, $totalPrice, $quantity, $pricePerTicket, $eventTypeLower, $request) {

                $orderCode = 'ORD-' . now()->timestamp . '-' . $event->id;

                // Data dasar (Termasuk LEVEL yang sekarang wajib disimpan)
                $orderData = [
                    'event_id'      => $event->id,
                    'user_id'       => Auth::id(),
                    'order_code'    => $orderCode,
                    'quantity'      => $quantity,
                    'total_price'   => $totalPrice,
                    'customer_name' => $validated['customer_name'],
                    'phone_number'  => $validated['phone_number'],
                    'school'        => $validated['school'],
                    'level'         => $validated['level'], // <--- KOREKSI: Level selalu disimpan
                    'status'        => 'pending',
                ];

                // Data Spesifik Pertandingan
                if ($eventTypeLower === 'pertandingan') {
                    $orderData['nik']               = $validated['nik'];
                    $orderData['kk']                = $validated['kk'];
                    $orderData['birth_place']       = $validated['birth_place'];
                    $orderData['birth_date']        = $validated['birth_date'];
                    $orderData['weight']            = $validated['weight'];
                    $orderData['competition_level'] = $validated['competition_level'];
                    $orderData['category']          = $validated['category'];

                    if ($request->filled('class')) {
                        $orderData['class'] = $request->input('class');
                    }
                }

                $order = Order::create($orderData);

                // 4. Integrasi Midtrans
                $itemName = 'Tiket ' . $event->title;

                // Format Nama Item: Tiket Event (Level - Kategori - Kelas)
                $details = [];
                if (!empty($validated['level'])) $details[] = $validated['level'];
                if (!empty($validated['competition_level'])) $details[] = $validated['competition_level'];
                if (!empty($validated['category'])) $details[] = $validated['category'];
                if (!empty($orderData['class'])) $details[] = $orderData['class'];

                if (!empty($details)) {
                    $itemName .= ' (' . implode(', ', $details) . ')';
                }

                $params = [
                    'transaction_details' => [
                        'order_id'     => $orderCode,
                        'gross_amount' => $totalPrice
                    ],
                    'item_details' => [[
                        'id'       => $event->id,
                        'price'    => $pricePerTicket,
                        'quantity' => $quantity,
                        'name'     => substr($itemName, 0, 50)
                    ]],
                    'customer_details' => [
                        'first_name' => $order->customer_name,
                        'phone'      => $order->phone_number,
                        'email'      => Auth::user()->email
                    ],
                    'enabled_payments' => ['bca_va', 'echannel', 'gopay', 'shopeepay', 'qris']
                ];

                $snap = $midtrans->createTransaction($params);
                $order->update(['midtrans_token' => $snap->token]);

                return $order;
            });

            return redirect()->route('orders.payment', $order);
        } catch (Throwable $e) {
            Log::error('Gagal membuat order: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Kembalikan ke mode error sopan (bukan dd)
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }
}
