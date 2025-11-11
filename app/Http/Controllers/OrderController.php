<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\MidtransService;

class OrderController extends Controller
{
    // Method create() Anda sudah benar, tidak perlu diubah.
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

    // Method store() yang sudah diperbaiki
    public function store(Request $request, Event $event, MidtransService $midtrans)
    {
        // 1. Tentukan aturan validasi dasar (level SELALU wajib)
        $baseRules = [
            'customer_name' => 'required|string|min:3',
            'phone_number' => 'required|string|min:10',
            'school' => 'required|string|min:3',
            'level' => 'required|string',
        ];

        // 2. Tambahkan aturan validasi kondisional (hanya untuk pertandingan)
        $dynamicRules = [];
        if ($event->event_type === 'pertandingan') {
            $dynamicRules['competition_level'] = 'required|string'; // Validasi level usia
            $dynamicRules['category'] = 'required|string'; // Validasi kategori tanding
        }

        // Gabungkan dan jalankan validasi
        $validated = $request->validate(array_merge($baseRules, $dynamicRules));

        // 3. Tetapkan quantity = 1
        $quantity = 1;

        // 4. Gunakan helper getPrice() dari Model Event
        $levelForPrice = $validated['level'] ?? null;
        $categoryForPrice = $validated['category'] ?? null;
        $pricePerTicket = $event->getPrice($levelForPrice, $categoryForPrice);

        // 5. Validasi harga dan kuota
        // Jika event statis, getPrice() akan mengembalikan harga statis (bukan null)
        if ($pricePerTicket === null || $pricePerTicket < 0) { // Izinkan harga 0 jika gratis
            return back()->withInput()->with('error', 'Kombinasi tingkatan/kategori tidak valid atau harga tidak ditemukan.');
        }

        $totalPrice = $pricePerTicket * $quantity;

        if ($event->ticket_quota < $quantity) {
            return back()->withInput()->with('error', 'Maaf, sisa kuota tiket tidak mencukupi.');
        }

        // 6. Jalankan Transaksi Database
        try {
            $order = DB::transaction(function () use ($validated, $event, $midtrans, $totalPrice, $quantity, $pricePerTicket) {
                $orderCode = 'ORD-' . now()->timestamp . '-' . $event->id;

                // Siapkan data untuk disimpan
                $orderData = [
                    'event_id' => $event->id,
                    'user_id' => Auth::id(),
                    'order_code' => $orderCode,
                    'quantity' => $quantity,
                    'total_price' => $totalPrice,
                    'customer_name' => $validated['customer_name'],
                    'phone_number' => $validated['phone_number'],
                    'school' => $validated['school'],
                    'status' => 'pending',
                    'level' => $validated['level'], // <-- Simpan level (sabuk)
                ];

                // PERBAIKAN: Simpan data pertandingan ke kolom baru jika ada
                if (isset($validated['competition_level'])) {
                    $orderData['competition_level'] = $validated['competition_level'];
                }
                if (isset($validated['category'])) {
                    $orderData['category'] = $validated['category'];
                }

                $order = Order::create($orderData);

                // Tentukan nama item untuk Midtrans
                $itemName = 'Tiket ' . $event->title;
                if ($event->event_type === 'ujian') {
                    $itemName .= ' (' . $validated['level'] . ')';
                } elseif ($event->event_type === 'pertandingan') {
                    // Buat nama lebih deskriptif
                    $itemName .= ' (' . $validated['competition_level'] . ' - ' . $validated['category'] . ')';
                }

                $params = [
                    'transaction_details' => ['order_id' => $orderCode, 'gross_amount' => $totalPrice],
                    'item_details' => [[
                        'id' => $event->id,
                        'price' => $pricePerTicket,
                        'quantity' => $quantity,
                        'name' => $itemName
                    ]],
                    'customer_details' => ['first_name' => $order->customer_name, 'phone' => $order->phone_number, 'email' => Auth::user()->email],
                    'enabled_payments' => ['bca_va', 'echannel', 'gopay']
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
            return back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }
}
