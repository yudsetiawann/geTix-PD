<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan ini

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
        $statusText = $order->achievement ?? 'PESERTA';

        // Konfigurasi
        $settings = $event->certificate_settings ?? [];
        $marginTopName = $settings['name_top_margin'] ?? 300;
        $marginTopStatus = $settings['status_top_margin'] ?? 450;
        $fontColor = $settings['font_color'] ?? '#000000';

        // --- BAGIAN KRUSIAL: MENGAMBIL GAMBAR ---

        // Kita gunakan Storage facade untuk mendapatkan konten file,
        // karena konfigurasi disk Anda sudah benar (mengarah ke public_html/storage di prod).
        // Ini jauh lebih aman daripada menebak path fisik.

        $diskName = config('filesystems.default_public_disk', 'public'); // Ambil disk aktif (public/upload_disk)

        if (Storage::disk($diskName)->exists($event->certificate_template)) {
            // Ambil konten file langsung dari disk
            $imageContent = Storage::disk($diskName)->get($event->certificate_template);
            // Encode ke base64
            $backgroundImage = base64_encode($imageContent);
        } else {
            // Fallback darurat jika file tidak ketemu (misal path salah)
            return back()->with('error', 'File template sertifikat tidak ditemukan.');
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
            'backgroundImage' => $backgroundImage,
        ]);

        // Set ukuran kertas
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Sertifikat-' . $order->customer_name . '.pdf');
    }
}
