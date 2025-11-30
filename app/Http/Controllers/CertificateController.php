<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function download(Order $order)
    {
        // 1. Validasi Keamanan
        if ((int) $order->user_id !== auth()->id()) {
            abort(403);
        }

        // Pastikan event punya template & sudah diterbitkan
        $event = $order->event;
        if (!$event->certificate_template || !$event->is_certificate_published) {
            return back()->with('error', 'Sertifikat belum tersedia.');
        }

        // 2. Tentukan Teks Prestasi
        // Jika kolom achievement kosong, default ke "PESERTA"
        // Jika event pertandingan, bisa lebih spesifik: "PESERTA KELAS A PUTRA"
        $statusText = $order->achievement ?? 'PESERTA';

        // Konfigurasi settings
        $settings = $event->certificate_settings ?? [];
        $marginTopName = $settings['name_top_margin'] ?? 300;
        $marginTopStatus = $settings['status_top_margin'] ?? 450;
        $fontColor = $settings['font_color'] ?? '#000000';

        // AMBIL ORIENTASI (Default ke landscape jika belum disetting)
        $orientation = $settings['orientation'] ?? 'landscape';

        // 3. Load View dengan gambar background
        $pdf = Pdf::loadView('pdf.certificate', [
            'order' => $order,
            'event' => $event,
            'statusText' => strtoupper($statusText),
            'marginTopName' => $marginTopName,
            'marginTopStatus' => $marginTopStatus,
            'fontColor' => $fontColor,
            // Konversi gambar ke base64 agar dompdf membacanya lebih cepat/aman
            'backgroundImage' => base64_encode(file_get_contents(public_path('storage/' . $event->certificate_template))),
            'orientation' => $orientation, // <-- KIRIM VARIABLE INI KE BLADE
        ]);

        // UBAH UKURAN KERTAS DINAMIS
        $pdf->setPaper('a4', $orientation);

        return $pdf->stream('Sertifikat-' . $order->customer_name . '.pdf');
    }
}
