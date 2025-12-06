<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Sertifikat {{ $order->customer_name }}</title>
  <style>
    @page {
      margin: 0px;
    }

    body {
      margin: 0px;
      font-family: 'Helvetica', 'Arial', sans-serif;
      /* Font standar sertifikat */
      color: {{ $layout['font_color'] }};
    }

    /* Container Halaman */
    .page {
      position: relative;
      width: 100%;
      height: 100%;
      overflow: hidden;
      page-break-after: always;
    }

    .page:last-child {
      page-break-after: avoid;
    }

    /* Background */
    .bg-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    /* --- STYLE UMUM DATA DEPAN --- */
    .data-field {
      position: absolute;
      /* left: {{ $layout['data_x'] }}px; */
      left: 390px;
      /* Semua rata kiri sejajar titik dua */
      /* font-size: {{ $layout['data_font_size'] }}pt; */
      font-size: 12pt;
      font-weight: bold;
      text-transform: uppercase;
      /* Line height diset normal agar tidak menabrak baris lain */
      line-height: 1.2;
      letter-spacing: 2px;
    }

    /* --- STYLE BARU UNTUK LEVEL (DARI TINGKAT ... KE TINGKAT ...) --- */
    .level-field {
      position: absolute;
      top: {{ $layout['level_y'] }}px;
      /* Posisi Vertikal diambil dari Controller */
      font-size: 11pt;
      /* Disamakan dengan data-field Anda */
      font-weight: bold;
      text-transform: uppercase;
      /* letter-spacing: 2px; */
      /* Disamakan dengan data-field Anda */
    }

    /* --- STYLE HALAMAN BELAKANG --- */
    .back-title {
      position: absolute;
      width: 100%;
      /* Agar bisa text-align center relatif terhadap lebar kertas */
      top: {{ $layout['back_title_y'] }}px;
      text-align: center;
      font-size: 16pt;
      /* Ukuran font judul */
      font-weight: bold;
      text-transform: uppercase;
      line-height: 1.2;
      letter-spacing: 2px;
    }

    .table-container {
      position: absolute;
      left: {{ $layout['table_x'] }}px;
      top: {{ $layout['table_y'] }}px;
      width: {{ $layout['table_width'] }};
    }

    .exam-table {
      width: 100%;
      border-collapse: collapse;
      font-size: {{ $layout['back_size'] }}pt;
      /* Background putih semi-transparan untuk menimpa garis tabel lama jika ada */
      background-color: rgba(255, 255, 255, 0.5);
    }

    .exam-table th,
    .exam-table td {
      border: 1px solid {{ $layout['font_color'] }};
      padding: 8px 10px;
      vertical-align: middle;
    }

    .exam-table th {
      text-align: center;
      font-weight: bold;
      text-transform: uppercase;
    }

    /* Lebar Kolom */
    .col-no {
      width: 5%;
      text-align: center;
    }

    .col-materi {
      width: 40%;
    }

    .col-angka {
      width: 15%;
      text-align: center;
    }

    .col-huruf {
      width: 40%;
      font-style: italic;
    }
  </style>
</head>

<body>

  {{-- HALAMAN 1: DEPAN --}}
  <div class="page">
    @if ($frontImage)
      <img src="data:image/png;base64,{{ $frontImage }}" class="bg-image">
    @endif

    {{--
           Karena background sudah ada tulisan "Nama :", "Tempat :", dll.
           Kita hanya perlu meletakkan ISINYA saja di sebelah kanan.
        --}}

    {{-- 1. NAMA --}}
    {{-- <div class="data-field" style="top: {{ $layout['name_y'] }}px;"> --}}
    <div class="data-field" style="top: 335px;">
      {{ $order->customer_name }}
    </div>

    {{-- 2. TEMPAT, TANGGAL LAHIR --}}
    {{-- <div class="data-field" style="top: {{ $layout['dob_y'] }}px;"> --}}
    <div class="data-field" style="top: 375px;">
      {{ $ttl }}
    </div>

    {{-- 3. RANTING / SEKOLAH --}}
    {{-- <div class="data-field" style="top: {{ $layout['school_y'] }}px;"> --}}
    <div class="data-field" style="top: 415px;">
      {{ $school }}
    </div>

    {{-- 4. DARI TINGKAT ... (BARU) --}}
    <div class="level-field" style="left: {{ $layout['level_from_x'] }}px;">
      {{ $currentLevel }}
    </div>

    {{-- 5. KE TINGKAT ... (BARU) --}}
    <div class="level-field" style="left: {{ $layout['level_to_x'] }}px;">
      {{ $nextLevel }}
    </div>

  </div>

  {{-- HALAMAN 2: BELAKANG --}}
  <div class="page">
    @if ($backImage)
      <img src="data:image/png;base64,{{ $backImage }}" class="bg-image">
    @endif

    {{-- JUDUL DAFTAR NILAI --}}
    <div class="back-title">
      DAFTAR NILAI
    </div>

    {{-- TABEL NILAI --}}
    <div class="table-container">
      <table class="exam-table">
        <thead>
          <tr>
            <th class="col-no">No.</th>
            <th class="col-materi">Materi Ujian</th>
            <th class="col-angka">Nilai Angka</th>
            <th class="col-huruf">Nilai Huruf</th>
          </tr>
        </thead>
        <tbody>
          @forelse($examResults as $index => $result)
            <tr>
              <td class="col-no">{{ $index + 1 }}.</td>
              <td class="col-materi">
                {{ $result->attribute->name ?? ($result->attribute_name ?? '-') }}
              </td>
              <td class="col-angka">{{ $result->value }}</td>
              <td class="col-huruf">{{ $result->terbilang }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="4" style="text-align: center; padding: 20px;">
                Belum ada data nilai.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>
