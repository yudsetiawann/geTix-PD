<x-app-layout title="Welcome">
    <x-slot name="header">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
        Selamat Datang
      </h1>
    </x-slot>

    <!-- ====== Hero Section ====== -->
    <section class="relative min-h-[70vh] md:min-h-[80vh] flex items-center justify-center overflow-hidden">
      <!-- Background Image -->
      <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/PD-hero.jpg') }}" alt="Atlit Pencak Silat" loading="lazy"
          class="w-full h-full object-cover object-center" />
        <!-- Overlay Gradient -->
        <div
          class="absolute inset-0 bg-linear-to-t from-slate-950/80 via-slate-950/70 to-black/30">
        </div>
      </div>

      <!-- Konten Hero -->
      <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 py-32 md:py-48 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight shadow-black/50 [text-shadow:0_2px_8px_var(--tw-shadow-color)]">
          Platform Tiket Resmi Perisai Diri
        </h1>
        <p class="mt-6 text-lg md:text-xl text-slate-200 max-w-3xl mx-auto shadow-black/50 [text-shadow:0_1px_4px_var(--tw-shadow-color)]">
          Temukan dan beli tiket untuk berbagai kejuaraan, ujian kenaikan tingkat, dan event lainnya di Perisai Diri cabang kabupaten Tasikmalaya.
        </p>
        <div class="mt-10">
          <a href="/events"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:shadow-blue-500/40 transform hover:scale-105 transition-all duration-300">
            Lihat Semua Event
          </a>
        </div>
      </div>
    </section>

    <!-- ====== Section "Cara Memesan Tiket" (Glassmorphism Cards) ====== -->
    <section class="py-16 sm:py-24 bg-white dark:bg-slate-900">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-16">
          <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
            Cara Memesan Tiket
          </h2>
          <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
            Hanya butuh 4 langkah mudah untuk mengamankan tiket Anda.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

          <!-- Card 1 -->
          <div
            class="text-center bg-white/70 dark:bg-slate-800/60 backdrop-blur-sm rounded-2xl p-8 shadow-lg ring-1 ring-slate-900/5 dark:ring-white/10">
            <div
              class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6 ring-8 ring-white/50 dark:ring-slate-900/50">
              <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">1. Pilih Event</h3>
            <p class="text-slate-600 dark:text-slate-400">Temukan event yang Anda inginkan dari daftar event yang tersedia.</p>
          </div>

          <!-- Card 2 -->
          <div
            class="text-center bg-white/70 dark:bg-slate-800/60 backdrop-blur-sm rounded-2xl p-8 shadow-lg ring-1 ring-slate-900/5 dark:ring-white/10">
            <div
              class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6 ring-8 ring-white/50 dark:ring-slate-900/50">
              <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">2. Isi Data Diri</h3>
            <p class="text-slate-600 dark:text-slate-400">Lengkapi data diri Anda sesuai formulir pemesanan tiket.</p>
          </div>

          <!-- Card 3 -->
          <div
            class="text-center bg-white/70 dark:bg-slate-800/60 backdrop-blur-sm rounded-2xl p-8 shadow-lg ring-1 ring-slate-900/5 dark:ring-white/10">
            <div
              class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6 ring-8 ring-white/50 dark:ring-slate-900/50">
              <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h6m-6 2.25h6M12 9v10.5m3.75-10.5H21a.75.75 0 0 0 .75-.75V7.5a.75.75 0 0 0-.75-.75H15.75m0 3H21m-3.75 0v10.5m0-10.5h-3.75m3.75 0h3.75M12 3v3.75m0 0h-3.75m3.75 0h3.75M12 3V.75" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">3. Bayar Aman</h3>
            <p class="text-slate-600 dark:text-slate-400">Lakukan pembayaran dengan metode yang Anda pilih melalui payment gateway.</p>
          </div>

          <!-- Card 4 -->
          <div
            class="text-center bg-white/70 dark:bg-slate-800/60 backdrop-blur-sm rounded-2xl p-8 shadow-lg ring-1 ring-slate-900/5 dark:ring-white/10">
            <div
              class="flex items-center justify-center h-16 w-16 bg-blue-100 dark:bg-blue-900/30 rounded-full mx-auto mb-6 ring-8 ring-white/50 dark:ring-slate-900/50">
              <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">4. Dapatkan E-Ticket</h3>
            <p class="text-slate-600 dark:text-slate-400">E-Ticket akan tersedia di halaman 'Tiket Saya' secara instan.</p>
          </div>

        </div>
      </div>
    </section>

    <!-- ====== Section "Kenapa Memilih E-Tick PD?" ====== -->
    <section class="py-16 sm:py-24 bg-slate-50 dark:bg-slate-950">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-16">
          <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
            Kenapa Memilih E-Tick PD?
          </h2>
          <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
            Kami memberikan kemudahan, keamanan, dan keabsahan tiket dalam satu platform.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

          <!-- Fitur 1 -->
          <div class="text-center">
            <div
              class="flex items-center justify-center h-16 w-16 bg-white dark:bg-slate-900 rounded-xl p-4 mb-5 mx-auto shadow-md">
              <svg class="h-10 w-10 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.623 0-1.31-.21-2.571-.6-3.751A11.959 11.959 0 0 1 12 2.714Z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Pembayaran Aman</h3>
            <p class="text-slate-600 dark:text-slate-400">Didukung oleh payment gateway terpercaya untuk menjamin keamanan
              transaksi Anda.</p>
          </div>

          <!-- Fitur 2 -->
          <div class="text-center">
            <div
              class="flex items-center justify-center h-16 w-16 bg-white dark:bg-slate-900 rounded-xl p-4 mb-5 mx-auto shadow-md">
              <svg class="h-10 w-10 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Tiket Resmi & Valid</h3>
            <p class="text-slate-600 dark:text-slate-400">Platform resmi yang bekerja sama langsung dengan panitia
              penyelenggara event.</p>
          </div>

          <!-- Fitur 3 -->
          <div class="text-center">
            <div
              class="flex items-center justify-center h-16 w-16 bg-white dark:bg-slate-900 rounded-xl p-4 mb-5 mx-auto shadow-md">
              <svg class="h-10 w-10 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Proses Instan</h3>
            <p class="text-slate-600 dark:text-slate-400">E-Ticket dengan QR Code unik diterbitkan otomatis setelah
              pembayaran berhasil.</p>
          </div>

        </div>
      </div>
    </section>

    <!-- ====== Section Galeri ====== -->
    <section class="py-16 sm:py-24 bg-white dark:bg-slate-900">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center mb-16">
          <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
            Galeri Kegiatan
          </h2>
          <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
            Momen dan semangat para atlit Perisai Diri dalam berbagai kegiatan.
          </p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/6.jpg') }}" alt="Galeri Silat 1">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/3.jpg') }}" alt="Galeri Silat 2">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/4.jpeg') }}" alt="Galeri Silat 3">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/2.jpg') }}" alt="Galeri Silat 4">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/7.jpg') }}" alt="Galeri Silat 5">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/8.jpg') }}" alt="Galeri Silat 6">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/5.jpg') }}" alt="Galeri Silat 7">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105"
                src="{{ asset('img/1.jpg') }}" alt="Galeri Silat 8">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ====== Final CTA Section ====== -->
    <section class="py-16 sm:py-24 bg-slate-50 dark:bg-slate-950">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2
          class="text-3xl font-bold tracking-tight sm:text-4xl bg-linear-to-r from-blue-600 to-slate-800 bg-clip-text text-transparent dark:from-blue-400 dark:to-slate-200">
          Jangan Ketinggalan Event Berikutnya!
        </h2>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-300 max-w-2xl mx-auto">
          Daftar dan dapatkan tiket Anda untuk menjadi bagian dari semangat dan persaudaraan Perisai Diri.
        </p>
        <div class="mt-10">
          <a href="/events"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:shadow-blue-500/40 transform hover:scale-105 transition-all duration-300">
            Cari Event Sekarang
          </a>
        </div>
      </div>
    </section>

  </x-app-layout>
