<x-guest-layout>
    {{--
      Catatan: Desain ini mengasumsikan 'x-guest-layout' menyediakan
      kartu/wrapper <div class="w-full sm:max-w-md ..."> seperti
      layout auth bawaan Laravel.
    --}}

    <!-- Ikon Email -->
    {{-- <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">
      <svg class="size-10 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none"
        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
      </svg>
    </div> --}}

    <!-- Judul -->
    <h2 class="text-center text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
      Verifikasi Email Anda
    </h2>

    <!-- Teks Penjelasan -->
    <p class="mt-4 text-center text-sm text-slate-600 dark:text-slate-400">
      {{ __('Terima kasih telah mendaftar! Untuk melanjutkan, silakan klik tautan verifikasi yang baru saja kami kirimkan ke email Anda.') }}
    </p>
    <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
      {{ __('Jika Anda tidak menerimanya, kami akan mengirim ulang.') }}
    </p>

    <!-- Status Alert (Jika link baru dikirim) -->
    @if (session('status') == 'verification-link-sent')
      <div
        class="mt-6 rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/50">
        <div class="flex">
          <div class="shrink-0">
            <svg class="size-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-green-700 dark:text-green-300">
              {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
            </p>
          </div>
        </div>
      </div>
    @endif

    <!-- Tombol Aksi -->
    <div class="mt-8 space-y-4">

      {{-- Tombol Kirim Ulang (Aksi Primer) --}}
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <div>
          {{-- Saya asumsikan x-primary-button adalah tombol biru/utama.
               Menambahkan class w-full akan membuatnya jadi tombol aksi utama. --}}
          <x-primary-button class="w-full flex justify-center">
            {{ __('Kirim Ulang Email Verifikasi') }}
          </x-primary-button>
        </div>
      </form>

      {{-- Tombol Log Out (Aksi Sekunder) --}}
      <div class="text-center">
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit"
            class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 hover:text-slate-900 dark:hover:bg-slate-800 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
            {{ __('Log Out') }}
          </button>
        </form>
      </div>

    </div>
  </x-guest-layout>
