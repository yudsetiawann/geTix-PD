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

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('orders.create', [
            'event' => $event,
            'levelPrices' => $event->level_prices,
            'hasDynamicPricing' => $event->has_dynamic_pricing,
            'eventType' => $event->event_type,
            'user' => $user,
        ]);
    }

    public function store(Request $request, Event $event, MidtransService $midtrans)
    {
        $user = Auth::user();
        $rules = [];
        $eventTypeLower = strtolower($event->event_type);
        $userLevelName = $user->level ? $user->level->name : null;

        if ($eventTypeLower === 'pertandingan') {
            $rules['weight']            = 'required|integer|min:10';
            $rules['competition_level'] = 'required|string';
            $rules['category']          = 'required|string';

            if ($request->input('category') === 'Tanding') {
                $rules['class'] = 'required|string';
            }
        }

        $validated = $request->validate($rules);

        $quantity = 1;
        $levelForPrice    = $userLevelName;
        $categoryForPrice = $validated['category'] ?? null;

        $pricePerTicket = $event->getPrice($levelForPrice, $categoryForPrice);

        if ($pricePerTicket === null) {
            return back()->withInput()->with('error', 'Harga tidak ditemukan untuk tingkat sabuk/kategori Anda.');
        }

        $totalPrice = $pricePerTicket * $quantity;

        if ($event->ticket_quota < $quantity) {
            return back()->withInput()->with('error', 'Maaf, sisa kuota tiket tidak mencukupi.');
        }

        try {
            $order = DB::transaction(function () use ($request, $validated, $event, $midtrans, $totalPrice, $quantity, $pricePerTicket, $eventTypeLower, $user, $userLevelName) {

                $orderCode = 'ORD-' . now()->timestamp . '-' . $event->id;

                $orderData = [
                    'event_id'      => $event->id,
                    'user_id'       => $user->id,
                    'order_code'    => $orderCode,
                    'quantity'      => $quantity,
                    'total_price'   => $totalPrice,
                    'status'        => 'pending',
                    'customer_name' => $user->name,
                    'phone_number'  => $user->phone_number,
                    'school'        => $user->unit ? $user->unit->name : '-',
                    'level'         => $userLevelName,
                    'birth_place'   => $user->place_of_birth,
                    'birth_date'    => $user->date_of_birth,
                ];

                if ($eventTypeLower === 'pertandingan') {
                    $orderData['nik'] = $user->nik;
                    $orderData['kk']  = $user->kk ?? null;
                    $orderData['weight']            = $validated['weight'];
                    $orderData['competition_level'] = $validated['competition_level'];
                    $orderData['category']          = $validated['category'];

                    if ($request->filled('class')) {
                        $orderData['class'] = $request->input('class');
                    }
                }

                $order = Order::create($orderData);

                $itemName = 'Tiket ' . $event->title;
                $details = [];
                if ($userLevelName) $details[] = $userLevelName;
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
                        'first_name' => $user->name,
                        'phone'      => $user->phone_number,
                        'email'      => $user->email
                    ],
                    'enabled_payments' => ['bca_va', 'echannel', 'gopay', 'shopeepay', 'qris', 'other_qris']
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

            return back()->withInput()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
        }
    }

    /**
     * Menangani pembayaran tunai/kolektif.
     */
    public function payCash(Order $order)
    {
        // 1. Validasi Kepemilikan Order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // 2. Cek Status Order (Hanya pending yang bisa diubah)
        if ($order->status !== 'pending') {
            return redirect()->route('my-tickets.index')
                ->with('error', 'Status pesanan tidak valid untuk pembayaran tunai.');
        }

        // 3. Update Order
        // Kita kosongkan token midtrans untuk menandakan ini bukan transaksi online lagi.
        // Status tetap 'pending', tapi user diarahkan untuk bayar manual.
        $order->update([
            'midtrans_token' => null,
            // Jika Anda memiliki kolom 'payment_method', uncomment baris di bawah:
            // 'payment_method' => 'cash_manual',
        ]);

        // 4. Redirect ke Halaman Tiket dengan pesan sukses
        return redirect()->route('my-tickets.index')
            ->with('success', 'Metode pembayaran Tunai/Kolektif dipilih. Silakan lakukan pembayaran ke Koordinator Cabang/Pelatih untuk verifikasi.');
    }
}
