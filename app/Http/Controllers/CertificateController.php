<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CertificateController extends Controller
{
    // Fungsi Helper Terbilang
    private function terbilang($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->terbilang($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = $this->terbilang((int)($nilai / 10)) . " Puluh" . $this->terbilang($nilai % 10);
        } else if ($nilai == 100) {
            $temp = "Seratus";
        }
        return trim($temp);
    }

    public function download(Order $order)
    {
        // 1. Validasi Kepemilikan Order
        if ((int)$order->user_id !== auth()->id()) {
            abort(403);
        }

        Carbon::setLocale('id');

        $event = $order->event;
        $settings = $event->certificate_settings ?? [];

        // --- 2. LOGIKA DETEKSI TIPE EVENT ---
        $isExam = false;
        $eventTypeLower = strtolower($event->event_type);
        if (str_contains($eventTypeLower, 'ujian') || str_contains($eventTypeLower, 'kenaikan')) {
            $isExam = true;
        }

        // --- 3. AMBIL GAMBAR ---
        $frontPath = $event->getFirstMediaPath('certificate_front');
        $backPath = $event->getFirstMediaPath('certificate_back');
        $frontImage = file_exists($frontPath) ? base64_encode(file_get_contents($frontPath)) : null;
        $backImage = ($backPath && file_exists($backPath)) ? base64_encode(file_get_contents($backPath)) : null;

        // --- 4. DATA PESERTA ---
        $tglLahir = '-';
        if ($order->birth_date) {
            $date = $order->birth_date instanceof Carbon ? $order->birth_date : Carbon::parse($order->birth_date);
            $tglLahir = $date->translatedFormat('d F Y');
        }
        $tempatLahir = $order->birth_place ? strtoupper($order->birth_place) : '-';
        $ttl = "$tempatLahir, " . strtoupper($tglLahir);
        $school = strtoupper($order->school ?? $order->agency ?? $order->ranting ?? '-');
        $statusText = strtoupper($order->achievement ?? 'PESERTA');

        // --- 5. LOGIKA KENAIKAN TINGKAT (BARU) ---
        // Kita ambil level saat ini dari order, lalu tentukan level berikutnya
        $currentLevel = strtoupper(trim($order->level ?? '-'));
        $nextLevel = '-';

        // Mapping urutan tingkat
        $levelMap = [
            'PEMULA'      => 'DASAR I',
            'DASAR I'     => 'DASAR II',
            'DASAR II'    => 'CAKEL',
            'CAKEL'       => 'PUTIH',
            'PUTIH'       => 'PUTIH HIJAU',
            'PUTIH HIJAU' => 'HIJAU',
            // Tambahkan jika ada tingkat selanjutnya, misal: 'HIJAU' => 'BIRU'
        ];

        // Cari level berikutnya berdasarkan map
        if (array_key_exists($currentLevel, $levelMap)) {
            $nextLevel = $levelMap[$currentLevel];
        } else {
            // Fallback jika input user tidak sesuai ejaan baku (Opsional)
            // Bisa dikosongkan atau disamakan
            $nextLevel = '-';
        }

        // --- 6. DATA NILAI ---
        $examResults = collect([]);
        if ($isExam) {
            $examResults = $order->examResults()->with('attribute')->get();
            foreach ($examResults as $result) {
                $result->terbilang = $this->terbilang($result->value);
            }
        }
        if ($examResults->isNotEmpty()) {
            $isExam = true;
        }

        // --- 7. KONFIGURASI LAYOUT ---
        $layout = [
            'orientation' => $settings['orientation'] ?? 'landscape',
            'font_color'  => $settings['font_color'] ?? '#000000',

            // Pertandingan
            'name_y'       => $settings['name_top_margin'] ?? 260,
            'status_y'     => $settings['status_top_margin'] ?? 450,

            // Ujian (Halaman Depan)
            'data_x'       => $settings['data_left_margin'] ?? 320,
            'dob_y'        => $settings['dob_top_margin'] ?? 300,
            'school_y'     => $settings['school_top_margin'] ?? 340,

            // --- KOORDINAT TINGKATAN (BARU) ---
            // Y position: Baris "Dari tingkat ... ke tingkat ..."
            'level_y'      => $settings['level_y'] ?? 495, // Estimasi posisi vertikal (sesuaikan!)

            // X position: Posisi horizontal untuk teks "Dari Tingkat" (PEMULA)
            'level_from_x' => $settings['level_from_x'] ?? 240, // Sesuaikan geser kanan/kiri

            // X position: Posisi horizontal untuk teks "Ke Tingkat" (DASAR I)
            'level_to_x'   => $settings['level_to_x'] ?? 420, // Sesuaikan geser kanan/kiri

            'data_font_size' => $settings['data_font_size'] ?? 12,

            // Ujian (Halaman Belakang)
            'back_title_y' => $settings['back_title_y'] ?? 130,
            'table_y'      => $settings['back_content_start_y'] ?? 180,
            'table_x'      => $settings['back_content_start_x'] ?? 100,
            'table_width'  => $settings['table_width'] ?? '80%',
            'back_size'    => $settings['back_font_size'] ?? 12,
        ];

        // --- 8. DATA VIEW ---
        $data = [
            'order'        => $order,
            'frontImage'   => $frontImage,
            'backImage'    => $backImage,
            'examResults'  => $examResults,
            'layout'       => $layout,
            'ttl'          => $ttl,
            'school'       => $school,
            'statusText'   => $statusText,

            // Variabel Baru
            'currentLevel' => $currentLevel,
            'nextLevel'    => $nextLevel,
        ];

        $viewName = $isExam ? 'pdf.certificate_exam' : 'pdf.certificate';

        $pdf = Pdf::loadView($viewName, $data);
        $pdf->setPaper('a4', $layout['orientation']);
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'dpi' => 96
        ]);

        return $pdf->stream('Sertifikat-' . preg_replace('/[^A-Za-z0-9\-]/', '', $order->customer_name) . '.pdf');
    }
}
