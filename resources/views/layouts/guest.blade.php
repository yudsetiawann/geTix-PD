<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" x-data="themeSwitcher()" x-init="initTheme()">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  {{-- TAMBAHKAN 3 BARIS INI UNTUK MENCEGAH CACHING --}}
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  {{-- AKHIR TAMBAHAN --}}

  <title>{{ config('app.name', 'Laravel') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo-PD.png') }}" />

  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  {{-- ⚡️ Tema langsung diterapkan sebelum halaman dirender --}}
  <script>
    (() => {
      const theme = localStorage.getItem('theme');
      const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      if (theme === 'dark' || (!theme && prefersDark)) {
        document.documentElement.setAttribute('data-theme', 'dark');
      } else {
        document.documentElement.removeAttribute('data-theme');
      }
    })();
  </script>

  {{-- ⚙️ Alpine Theme Controller --}}
  <script>
    function themeSwitcher() {
      return {
        darkMode: document.documentElement.getAttribute('data-theme') === 'dark',
        toggle() {
          this.darkMode = !this.darkMode;
          if (this.darkMode) {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('theme', 'dark');
          } else {
            document.documentElement.removeAttribute('data-theme');
            localStorage.setItem('theme', 'light');
          }
        }
      }
    }
  </script>

  <script src="//unpkg.com/alpinejs" defer></script>

  {{-- Pastikan app.css dimuat setelah skrip tema --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- 🧩 Sembunyikan elemen x-cloak sebelum Alpine aktif --}}
  <style>
    [x-cloak] {
      display: none !important;
    }

    /* Opsional: mencegah flash warna putih saat dark mode */
    html[data-theme="dark"] {
      background-color: #0f172a;
    }

    html:not([data-theme="dark"]) {
      background-color: #f8fafc;
    }
  </style>
</head>

<body
  class="font-sans text-gray-900 dark:text-gray-100 antialiased min-h-screen flex flex-col sm:justify-center items-center bg-gray-100 dark:bg-gray-900">

  {{-- === TOMBOL DARK MODE === --}}
  <div class="absolute top-4 right-4">
    <button @click="toggle()" type="button"
      class="relative flex items-center w-full rounded-md p-1 text-gray-500 dark:text-gray-300 hover:bg-white/5 transition">
      <span class="sr-only">Toggle dark mode</span>

      {{-- Ikon Bulan (tampil saat light mode) --}}
      <svg x-cloak x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="2" stroke="currentColor" class="size-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75
            0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25
            C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0
            9.002-5.998Z" />
      </svg>

      {{-- Ikon Matahari (tampil saat dark mode) --}}
      <svg x-cloak x-show="darkMode" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke-width="2" stroke="currentColor" class="size-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21
            12h-2.25m-.386 6.364-1.591-1.591M12
            18.75V21m-4.773-4.227-1.591
            1.591M5.25 12H3m4.227-4.773L5.636
            5.636M15.75 12a3.75 3.75 0
            1 1-7.5 0 3.75 3.75 0 0 1
            7.5 0Z" />
      </svg>
    </button>
  </div>
  {{-- === AKHIR TOMBOL DARK MODE === --}}

  <div class="mt-16 sm:mt-0">
    <a href="/">
      <x-application-logo class="w-24 h-20 fill-current text-gray-500" />
    </a>
  </div>

  <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
    {{ $slot }}
  </div>

</body>

</html>
