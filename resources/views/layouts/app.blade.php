<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" type="image/png" sizes="59x47" href="{{ asset('img/Icon-PD.png') }}?v=1" />
  <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  {{-- === 1. TAMBAHKAN BLOCKING SCRIPT DI SINI === --}}
  <script>
    // Skrip ini akan berjalan sebelum halaman dirender
    if (localStorage.getItem('darkMode') === 'true' ||
      (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      // Terapkan data-theme="dark" secara instan
      document.documentElement.setAttribute('data-theme', 'dark');
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
  </script>
  {{-- ========================================= --}}

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- === 2. PINDAHKAN LOGIKA ALPINE KE BODY === --}}

<body class="h-full font-sans antialiased bg-gray-100 dark:bg-gray-900" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    init() {
        // $watch HANYA bertugas mengupdate atribut SAAT DI-TOGGLE
        this.$watch('darkMode', val => {
            localStorage.setItem('darkMode', val);
            if (val) {
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.removeAttribute('data-theme');
            }
        });
    }
}"
  x-init="init()">

  <div class="min-h-full">
    {{-- Navbar sekarang akan otomatis membaca state 'darkMode' dari body --}}
    <x-navbar />

    @isset($header)
      <header class="pt-16 bg-white text-center dark:bg-gray-800 shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          {{ $header }}
        </div>
      </header>
    @endisset

    <main>
      <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        {{ $slot }}
      </div>
    </main>
    <x-footer />
  </div>
</body>

</html>
