<!-- Logo di tengah -->
<p align="center">
<img src="public/img/Logo-PD.png" alt="Logo Perisai Diri" width="150">
</p>
<!-- Judul Utama -->
<h1 align="center">
geTix PD
</h1>
<!-- Subjudul & Badges -->
<p align="center">
<strong>Sistem E-Ticketing & Manajemen Event untuk Keluarga Silat Nasional Perisai Diri</strong>


Sebuah proyek Pengabdian Kepada Masyarakat (PKM) untuk mentransformasi manajemen event dari manual menjadi digital.
</p>
<p align="center">
<img src="https://www.google.com/search?q=https://img.shields.io/badge/Laravel-12-FF2D20.svg%3Fstyle%3Dfor-the-badge%26logo%3Dlaravel" alt="Laravel 12">
<img src="https://www.google.com/search?q=https://img.shields.io/badge/Filament-4-F59E0B.svg%3Fstyle%3Dfor-the-badge" alt="Filament 4">
<img src="https://www.google.com/search?q=https://img.shields.io/badge/Tailwind_CSS-4-38B2AC.svg%3Fstyle%3Dfor-the-badge%26logo%3Dtailwind-css" alt="Tailwind 4">
<img src="https://www.google.com/search?q=https://img.shields.io/badge/PHP-8.3%252B-777BB4.svg%3Fstyle%3Dfor-the-badge%26logo%3Dphp" alt="PHP 8.3+">
</p>
🎯 Latar Belakang: Masalah
Secara tradisional, proses pendaftaran event di Perisai Diri (seperti Ujian Kenaikan Tingkat atau Kejuaraan) seringkali bergantung pada proses manual:

📝 Pendaftaran: Formulir kertas yang harus diisi dan dikumpulkan.
💰 Pembayaran: Pembayaran tunai di sekretariat yang sulit dilacak.
📊 Rekap Data: Panitia harus memasukkan ulang data dari kertas ke Excel, rawan human error.
🎟️ Tiket & Absensi: Menggunakan daftar hadir cetak atau tiket fisik yang mudah hilang atau dipalsukan.
⏰ Waktu: Proses manual ini memakan waktu dan tenaga panitia yang berharga.
🚀 Solusi: geTix PD

geTix PD adalah aplikasi web lengkap yang mentransformasi seluruh proses ini menjadi satu alur digital yang efisien, aman, dan profesional.
Untuk Peserta: Pengalaman pendaftaran yang modern, cepat, dan aman dari mana saja.
Untuk Panitia: Satu "Pusat Kontrol" untuk mengelola semua aspek event, mulai dari penjualan tiket hingga check-in di hari H.

✨ Fitur Utama
🎨 Halaman Pengguna (Frontend)
- Daftar Event: Galeri visual semua event yang akan datang.
- Detail Event: Halaman lengkap berisi deskripsi, poster, galeri foto, lokasi (embed Google Maps), dan info kontak.
- Pemesanan Cerdas: Form pemesanan dinamis yang menyesuaikan input dan harga berdasarkan tipe event (misal: Ujian vs. Pertandingan).
- Gateway Pembayaran: Integrasi penuh dengan Midtrans (GoPay, BCA VA, Mandiri, dll.) untuk pembayaran instan dan aman.
- Notifikasi Email: Sistem otomatis mengirim e-ticket ke email peserta setelah pembayaran lunas.
- Halaman "Tiket Saya": Portal bagi pengguna untuk melihat riwayat transaksi, mengunduh ulang tiket, atau membatalkan pesanan yang masih pending.
- Dark Mode Toggle: Tampilan light/dark mode yang modern dan responsif.

🛡️ Panel Admin & Scanner (Backend - Filament 4)
Dibangun menggunakan Filament 4 sebagai panel admin yang tangguh, dengan 3 level akses:

1. Super Admin (Role: admin)
- Dashboard Statistik: Menampilkan total pendapatan, grafik penjualan, dan tiket terjual per event secara real-time (dengan Lazy Loading).
- Manajemen Event (CRUD): Membuat, mengedit, dan menghapus event.
- Harga Dinamis: Kemampuan untuk mengatur harga tiket statis (harga tunggal) atau harga dinamis berdasarkan dropdown (misal: harga Ujian Kenaikan Tingkat berdasarkan sabuk, atau harga Kejuaraan berdasarkan kategori tanding).
- Manajemen Peserta (CRUD): Mengelola database atlet/anggota.
- Impor Data: Fitur impor data peserta massal dari file Excel/CSV.
- Manajemen User: Mengatur pengguna sistem dan role mereka (admin, scanner, user).
- Manajemen Absensi: Mengelola absensi latihan harian atlet (terpisah dari event).

2. Panitia Lapangan (Role: scanner)
- Hanya bisa mengakses 2 halaman: Dashboard (hanya melihat) dan Halaman Scan E-Ticket.
- Akses menu lain (Users, Events, Peserta) disembunyikan.

3. User Biasa (Role: user)
Tidak bisa mengakses panel admin sama sekali (canAccessPanel = false).

🎟️ Fitur Inti:
1. E-Ticket & Sistem Check-In
Ini adalah jantung dari aplikasi:
Pembuatan E-Ticket Otomatis: Setelah MidtransController menerima webhook pembayaran paid, sistem otomatis:
- Menyimpan ticket_code unik ke database.
- Meng-update stok ticket_quota dan ticket_sold di event.
- Membuat e-ticket PDF yang didesain khusus (laravel-dompdf).
- Menghasilkan QR Code Unik (simple-qrcode) di dalam PDF.
- Menyimpan PDF ke storage (spatie/laravel-medialibrary).

2. Sistem Check-In Scanner:
- Panitia/Scanner membuka halaman "Scan E-Ticket" di HP atau Laptop.
- Menggunakan html5-qrcode untuk memindai QR code dari e-ticket peserta.
- Sistem memvalidasi tiket secara real-time:
    BERHASIL: Jika tiket valid dan belum check-in.
    DUPLIKAT: Jika tiket sudah pernah di-scan.
    PENDING: Jika pembayaran tiket belum lunas.
    GAGAL: Jika kode tiket tidak ada di database.
- Tersedia input manual (fallback) jika kamera gagal memindai.

📸 Tangkapan Layar
Halaman Depan (Event)
Halaman "Tiket Saya"
<img src="https://www.google.com/search?q=https://i.imgur.com/v88Ea8e.jpeg" alt="Halaman Depan" width="400">
<img src="https://www.google.com/search?q=https://i.imgur.com/kM8G1uR.png" alt="Halaman Tiket Saya" width="400">
Panel Admin (Dashboard)
Panel Admin (Scanner Check-in)
<img src="https://www.google.com/search?q=https://i.imgur.com/R3aBwY5.png" alt="Dashboard Admin" width="400">
<img src="https://www.google.com/search?q=https://i.imgur.com/P0N7J3s.png" alt="Halaman Scanner" width="400">

🛠️ Tumpukan Teknologi
Backend: Laravel 12, PHP 8.3
Frontend: Blade, Tailwind CSS 4, Alpine.js
Panel Admin: Filament 4
Database: MySQL
Pembayaran: Midtrans (Snap)
Fitur Inti:
- barryvdh/laravel-dompdf (Pembuatan PDF E-Ticket)
- simplesoftwareio/simple-qrcode (Pembuatan QR Code)
- spatie/laravel-medialibrary (Manajemen Upload Gambar & PDF)
- maatwebsite/excel (Impor & Ekspor Data Peserta)
- aravel/breeze (Autentikasi Blade)

Deployment: cPanel/Shared Hosting (dengan konfigurasi filesystems kustom)
