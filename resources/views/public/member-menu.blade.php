<x-app-layout title="Direktori Anggota">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
      Direktori Anggota
    </h1>
  </x-slot>

  <div class="py-12 px-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Opsi 1: Daftar Semua Anggota --}}
        <a href="{{ route('public.athletes.all') }}"
          class="group relative block overflow-hidden rounded-xl border border-slate-200 bg-white p-8 hover:border-blue-500 hover:ring-1 hover:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 transition-all duration-300">

          <span
            class="absolute right-4 top-4 rounded-full bg-blue-100 px-3 py-1 text-xs font-medium text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
            Global
          </span>

          <div class="mt-4 text-slate-900 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-12 text-blue-600 group-hover:scale-110 transition-transform">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg>
          </div>

          <h3 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">Daftar Anggota</h3>
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Lihat seluruh anggota aktif yang telah terverifikasi dari semua unit latihan.
          </p>
        </a>

        {{-- Opsi 2: Daftar Ranting --}}
        <a href="{{ route('public.units') }}"
          class="group relative block overflow-hidden rounded-xl border border-slate-200 bg-white p-8 hover:border-emerald-500 hover:ring-1 hover:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 transition-all duration-300">

          <span
            class="absolute right-4 top-4 rounded-full bg-emerald-100 px-3 py-1 text-xs font-medium text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
            Per Unit
          </span>

          <div class="mt-4 text-slate-900 dark:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-12 text-emerald-600 group-hover:scale-110 transition-transform">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
            </svg>
          </div>

          <h3 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">Daftar Ranting</h3>
          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
            Cari anggota berdasarkan lokasi Unit Latihan atau Ranting mereka.
          </p>
        </a>

      </div>
    </div>
  </div>
</x-app-layout>
