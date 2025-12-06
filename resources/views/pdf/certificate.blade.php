<!DOCTYPE html>
<html>

<head>
  <style>
    @page {
      margin: 0px;
      /* Mengambil orientasi dari layout */
      size: A4 {{ $layout['orientation'] ?? 'landscape' }};
    }

    body {
      margin: 0px;
      font-family: 'Courier', sans-serif; // Arial, Courier, Helvetica
      /* Mengambil warna font dari layout */
      color: {{ $layout['font_color'] ?? '#000000' }};
      width: 100%;
      height: 100%;
    }

    .background {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      object-fit: cover;
    }

    /* Style Khusus Pertandingan (Tengah) */
    .content-name {
      position: absolute;
      width: 100%;
      text-align: center;
      /* Nama Rata Tengah */
      top: {{ $layout['name_y'] ?? 300 }}px;
      font-size: 36px;
      font-weight: bold;
      text-transform: uppercase;
    }

    .content-status {
      position: absolute;
      width: 100%;
      text-align: center;
      /* Juara/Peserta Rata Tengah */
      top: {{ $layout['status_y'] ?? 450 }}px;
      font-size: 24px;
      /* font-weight: normal; */
      font-weight: bold;
      text-transform: uppercase;
    }
  </style>
</head>

<body>
  {{-- Gunakan frontImage untuk sertifikat pertandingan (single page) --}}
  @if (isset($frontImage) && $frontImage)
    <img src="data:image/jpeg;base64,{{ $frontImage }}" class="background">
  @endif

  <div class="content-name">
    {{ $order->customer_name }}
  </div>

  <div class="content-status">
    {{ $statusText }}
  </div>
</body>

</html>
