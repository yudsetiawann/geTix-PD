<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Menampilkan halaman "Tiket Saya"
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('event')
            ->latest()
            ->paginate(10);
        return view('profile.my-tickets', compact('orders'));
    }

    // Menampilkan E-Ticket PDF di browser
    public function show(Order $order)
    {
        // PERBAIKAN: Tambahkan (int) sebelum $order->user_id
        if ((int) $order->user_id !== Auth::id() || $order->status !== 'paid' || !$order->ticket_code) {
            abort(403);
        }

        $pdf = Pdf::loadView('pdf.eticket', compact('order'));
        return $pdf->stream('e-ticket-' . $order->ticket_code . '.pdf');
    }

    // Mengunduh E-Ticket PDF
    public function download(Order $order)
    {
        // PERBAIKAN: Tambahkan (int) sebelum $order->user_id
        if ((int) $order->user_id !== Auth::id() || $order->status !== 'paid') {
            abort(403);
        }

        $ticketMedia = $order->getFirstMedia('etickets');
        if ($ticketMedia) {
            return $ticketMedia;
        } else {
            $pdf = Pdf::loadView('pdf.eticket', compact('order'));
            return $pdf->download('e-ticket-' . $order->ticket_code . '.pdf');
        }
    }

    // Membatalkan order yang masih pending
    public function cancel(Order $order)
    {
        // PERBAIKAN: Tambahkan (int) sebelum $order->user_id
        if ((int) $order->user_id !== Auth::id() || $order->status !== 'pending') {
            abort(403);
        }

        $order->delete();
        return redirect()->route('my-tickets.index')->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
