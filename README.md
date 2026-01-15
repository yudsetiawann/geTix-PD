<p align="center">
<img src="public/img/Logo-PD.png" alt="Logo Perisai Diri" width="150">
</p>

<h1 align="center">
PD-dig (Perisai Diri Digital)
</h1>

<p align="center">
<strong>Sistem Informasi Manajemen Anggota & Event Terintegrasi<br>Keluarga Silat Nasional Indonesia Perisai Diri Kabupaten Tasikmalaya</strong>
<br><br>
<em>"From Paper to Digital Ecosystem"</em> — Transformasi total manajemen organisasi dari pendataan manual menuju ekosistem digital yang terpusat, valid, dan efisien.
</p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-12-FF2D20.svg?style=for-the-badge&logo=laravel" alt="Laravel 12">
<img src="https://img.shields.io/badge/Filament-4-F59E0B.svg?style=for-the-badge" alt="Filament 4">
<img src="https://img.shields.io/badge/Tailwind_CSS-4-38B2AC.svg?style=for-the-badge&logo=tailwind-css" alt="Tailwind 4">
<img src="https://img.shields.io/badge/PHP-8.3%2B-777BB4.svg?style=for-the-badge&logo=php" alt="PHP 8.3+">
</p>

<hr>

## 🎯 Latar Belakang & Transformasi
Sebelumnya, manajemen organisasi menghadapi tantangan data yang terfragmentasi:
* **Pendataan Anggota:** Data tersebar di kertas formulir atau file Excel terpisah di setiap ranting, menyebabkan duplikasi dan ketidakvalidan data anggota.
* **Pendaftaran Event:** Peserta harus mengisi formulir berulang kali setiap ada ujian atau kejuaraan.
* **Validasi:** Sulit memverifikasi status aktif anggota secara *real-time*.

**PD-dig Hadir Sebagai Solusi:**
Bukan sekadar aplikasi tiket, melainkan **Platform Manajemen Organisasi (ERP Sederhana)**. Sistem ini menjadikan **Profil Anggota sebagai "Single Source of Truth"**. Data hanya diinput sekali, diverifikasi berjenjang, dan digunakan otomatis untuk pendaftaran event, ujian, hingga penerbitan sertifikat.

---

## 💎 Fitur Unggulan: Manajemen Keanggotaan (Core System)

Sistem ini memiliki *business logic* yang ketat untuk menjamin validitas data anggota.

### 1. Siklus Hidup Verifikasi (Verification Lifecycle)
Menjamin bahwa hanya anggota yang valid yang tercatat di database.
* **Incomplete:** User baru mendaftar, data belum lengkap.
* **Pending:** User melengkapi data profil & memilih Unit Latihan. Data menunggu persetujuan Pelatih.
* **Approved:** Pelatih memvalidasi bahwa user adalah anggota unitnya. **NIA Terbit Otomatis.**
* **Rejected:** Data ditolak (wajib menyertakan alasan) untuk diperbaiki user.

### 2. Snapshot Integrity & Locking
* **Data Consistency:** Jika anggota yang sudah `Approved` mengubah data sensitif (Nama, Tanggal Lahir, Unit), status otomatis reset ke `Pending` untuk diverifikasi ulang.
* **Pre-filled Forms:** Saat mendaftar event, formulir otomatis terisi dari data profil (Read-Only). Tidak ada lagi kesalahan penulisan nama di sertifikat.

### 3. Generator Nomor Induk Anggota (NIA) Otomatis
Format unik yang digenerate sistem saat status *Approved*:
> Format: `TahunMasuk` + `TglLahir(YYYYMMDD)` + `NoUrut`
> Contoh: **201904050001**

---

## 🚀 Fitur Frontend (Publik & Anggota)

Tampilan antarmuka modern dan responsif untuk anggota dan masyarakat umum.

### 🏠 Beranda (Homepage) & Informasi
* **Hero Section:** Navigasi cepat ke Direktori Ranting & Pelatih.
* **Direktori Anggota:** Transparansi data organisasi.
    * *Daftar Ranting:* Grid interaktif menampilkan unit latihan & jumlah anggota aktif.
    * *Daftar Pelatih:* Profil pelatih resmi yang terdaftar.
* **Info Cabang:** Sejarah Perisai Diri & Peta Lokasi Sekretariat (Google Maps Embed).
* **Event Dashboard:** Menampilkan 3 event terbaru secara dinamis.

### 👤 Profil & Dashboard Anggota
* **Manajemen Profil:** Input biodata lengkap (NIK, Pekerjaan, Tingkatan Sabuk, Unit Latihan).
* **Tiket Saya:** Riwayat transaksi event, status pembayaran, dan unduh E-Ticket.
* **Proteksi Akses:** Hanya anggota berstatus **Verified/Approved** yang dapat mengakses menu pembelian tiket event.

---

## 🎫 Manajemen Event & Ticketing

Sistem pendaftaran event yang terintegrasi penuh dengan data keanggotaan.

### Pendaftaran Cerdas
* **Middleware Protection:** Mencegah user *Pending/Rejected* mendaftar event.
* **Form Dinamis:** Hanya meminta input variabel (misal: Berat Badan untuk kategori tanding), sisanya mengambil dari profil.

### Metode Pembayaran (Flexible Payment)
1.  **Online (Midtrans Snap):** QRIS, E-Wallet, Virtual Account (Otomatis Lunas).
2.  **Tunai/Kolektif (New):** Opsi bayar manual ke koordinator cabang. Status tiket `Pending` hingga dikonfirmasi Admin.

### Output Dokumen
* **E-Ticket PDF:** Dilengkapi QR Code unik untuk validasi kehadiran.
* **Sertifikat Digital:** Generate otomatis (Front & Back page) lengkap dengan nilai ujian.

---

## 🛡️ Hak Akses & Panel (Role Management)

Sistem membagi akses ke dalam beberapa panel spesifik:

### 1. Panel Admin (Super Admin - Filament v4)
Pusat kontrol organisasi.
* **Dashboard Statistik:** Grafik penjualan & ringkasan anggota.
* **Master Data:** CRUD Unit Latihan & Tingkatan Sabuk (untuk dropdown dinamis).
* **Manajemen Event:** Atur harga tiket, kuota, dan galeri.
* **Approval Pembayaran:** Validasi pembayaran tunai/kolektif.
* **Manajemen User:** Reset password & kelola role.

### 2. Panel Pelatih (Coach Dashboard)
Didesain khusus untuk pelatih unit/ranting.
* **Verifikasi Anggota:** Tombol *Approve* (Terbitkan NIA) atau *Reject* untuk pendaftar baru di unit binaannya.
* **Monitoring Unit:** Melihat daftar seluruh atlet binaan yang aktif.

### 3. Panel Scanner (Event Crew)
* **QR Validation:** Scan E-Ticket menggunakan kamera HP/Laptop.
* **Real-time Status:** Deteksi tiket *Valid*, *Pending*, *Expired*, atau *Duplicate* (sudah masuk).

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

Dibangun dengan teknologi modern untuk performa dan skalabilitas jangka panjang.

| Komponen | Teknologi |
| :--- | :--- |
| **Framework** | Laravel 12 |
| **Language** | PHP 8.3 |
| **Admin Panel** | FilamentPHP v4 |
| **Frontend** | Blade + Tailwind CSS 4 + Alpine.js |
| **Database** | MySQL |
| **Payment Gateway** | Midtrans (Snap) |
| **PDF Engine** | barryvdh/laravel-dompdf |
| **QR Engine** | simplesoftwareio/simple-qrcode |
| **Storage** | Spatie Media Library |

---

<p align="center">
Dibuat dengan ❤️ untuk kemajuan Perisai Diri Kabupaten Tasikmalaya.
</p>
