<!-- 8. Footer (Redesain Modern) -->
<footer class="bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8">
  <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Bagian Atas Footer --}}
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-12 mb-12">

      <!-- Kolom 1: Brand (Lebar 5 kolom) -->
      <div class="md:col-span-5">
        <div class="flex items-center gap-3 mb-6">
          <!-- Logo -->
          <x-application-logo class="h-10 w-auto" />
          <span class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">geTix PD</span>
        </div>
        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed max-w-sm">
          Platform e-ticketing resmi untuk semua kegiatan Keluarga Silat Nasional Indonesia Perisai Diri.
          Kami menghadirkan pengalaman pemesanan tiket yang mudah, aman, dan terpercaya.
        </p>
      </div>

      <!-- Kolom 2: Tautan Cepat (Lebar 3 kolom) -->
      <div class="md:col-span-3 md:pl-8">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-6">
          Menu
        </h3>
        <ul class="space-y-4">
          <li>
            <a href="/"
              class="text-sm text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 flex items-center gap-2 group">
              <span class="h-px w-0 bg-blue-600 transition-all duration-300 group-hover:w-3"></span>
              Beranda
            </a>
          </li>
          <li>
            <a href="/events"
              class="text-sm text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 flex items-center gap-2 group">
              <span class="h-px w-0 bg-blue-600 transition-all duration-300 group-hover:w-3"></span>
              Semua Event
            </a>
          </li>
          <li>
            <a href="/my-receipts"
              class="text-sm text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200 flex items-center gap-2 group">
              <span class="h-px w-0 bg-blue-600 transition-all duration-300 group-hover:w-3"></span>
              Tiket Saya
            </a>
          </li>
        </ul>
      </div>

      <!-- Kolom 3: Sosial Media (Lebar 4 kolom) -->
      <div class="md:col-span-4">
        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-6">
          Ikuti Kami
        </h3>
        <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">
          Tetap terhubung untuk mendapatkan info kejuaraan dan event terbaru.
        </p>
        <div class="flex items-center gap-4">
          {{-- Instagram --}}
          <a href="https://www.instagram.com/pd_kabtasikofc/" target="_blank"
            class="flex items-center justify-center size-10 rounded-full bg-slate-100 text-slate-500 hover:bg-pink-600 hover:text-white dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-pink-600 dark:hover:text-white transition-all duration-300">
            <span class="sr-only">Instagram</span>
            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.9c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                clip-rule="evenodd" />
            </svg>
          </a>
          {{-- YouTube --}}
          <a href="https://www.youtube.com/@perisaidirikabtasikofficial" target="_blank"
            class="flex items-center justify-center size-10 rounded-full bg-slate-100 text-slate-500 hover:bg-red-600 hover:text-white dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-red-600 dark:hover:text-white transition-all duration-300">
            <span class="sr-only">YouTube</span>
            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z"
                clip-rule="evenodd" />
            </svg>
          </a>
          {{-- Facebook --}}
          <a href="https://www.facebook.com/groups/122776311120420" target="_blank"
            class="flex items-center justify-center size-10 rounded-full bg-slate-100 text-slate-500 hover:bg-blue-600 hover:text-white dark:bg-slate-800 dark:text-slate-400 dark:hover:bg-blue-600 dark:hover:text-white transition-all duration-300">
            <span class="sr-only">Facebook</span>
            <svg class="size-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
              <path fill-rule="evenodd"
                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                clip-rule="evenodd" />
            </svg>
          </a>
        </div>
      </div>
    </div>

    {{-- Garis Pemisah & Copyright --}}
    <div
      class="border-t border-slate-200 dark:border-slate-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-2">

      {{-- Copyright --}}
      <p class="text-sm text-slate-500 dark:text-slate-500 text-center md:text-left">
        &copy; {{ date('Y') }} geTix PD. All rights reserved.
      </p>

      {{-- Created By (Permintaan Anda) --}}
      {{-- <p class="text-sm text-slate-500 dark:text-slate-500 flex items-center gap-1">
        Created by
        <a href="https://www.instagram.com/yudstwan_" target="_blank"
          class="font-medium text-slate-700 dark:text-slate-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
          @yudstwan_
        </a>
      </p> --}}
    </div>
  </div>
</footer>
