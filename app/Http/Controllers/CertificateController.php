<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage; // Tidak wajib lagi jika pakai getPath() Spatie

class CertificateController extends Controller
{
    public function download(Order $order)
    {
        // 1. Validasi Keamanan
        if ((int)$order->user_id !== auth()->id()) {
            abort(403);
        }

        $event = $order->event;

        // --- BAGIAN 1: AMBIL MEDIA DARI SPATIE ---
        // Ambil file pertama dari collection 'certificate_template'
        $mediaItem = $event->getFirstMedia('certificate_template');

        // Validasi: Pastikan media ada & status published
        if (!$mediaItem || !$event->is_certificate_published) {
            return back()->with('error', 'Sertifikat belum tersedia atau template belum diupload.');
        }

        // 2. Tentukan Teks Prestasi
        $statusText = $order->achievement ?? 'PESERTA';

        // Konfigurasi
        $settings = $event->certificate_settings ?? [];
        $marginTopName = $settings['name_top_margin'] ?? 300;
        $marginTopStatus = $settings['status_top_margin'] ?? 450;
        $fontColor = $settings['font_color'] ?? '#000000';

        // --- BAGIAN 2: PROSES GAMBAR KE BASE64 ---

        // Spatie memudahkan kita mengambil full path fisik file di server
        // Contoh: /var/www/html/storage/app/public/1/template.jpg
        $path = $mediaItem->getPath();

        if (file_exists($path)) {
            // Baca file langsung dari path fisik
            $imageContent = file_get_contents($path);
            // Encode ke base64 agar aman dirender oleh DomPDF
            $backgroundImage = base64_encode($imageContent);
        } else {
            return back()->with('error', 'File fisik template sertifikat hilang dari server.');
        }

        // ----------------------------------------

        // 3. Load View dengan gambar background
        $pdf = Pdf::loadView('pdf.certificate', [
            'order' => $order,
            'event' => $event,
            'statusText' => strtoupper($statusText),
            'marginTopName' => $marginTopName,
            'marginTopStatus' => $marginTopStatus,
            'fontColor' => $fontColor,
            'backgroundImage' => $backgroundImage, // Ini dikirim sebagai base64 string
        ]);

        // Set ukuran kertas (Ambil dari settings jika ada, default landscape)
        $orientation = $settings['orientation'] ?? 'landscape';
        $pdf->setPaper('a4', $orientation);

        return $pdf->stream('Sertifikat-' . $order->customer_name . '.pdf');
    }
}
