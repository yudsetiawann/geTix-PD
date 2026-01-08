<div class="py-12 px-5">
  <div class="pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- Header & Search --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Ranting / Unit</h2>
        <nav class="flex text-sm text-slate-500 dark:text-slate-400 mt-1" aria-label="Breadcrumb">
          <ol class="flex items-center space-x-2">
            <li><a href="{{ route('public.menu') }}" class="hover:text-blue-600">Direktori</a></li>
            <li><span class="text-slate-400">/</span></li>
            <li class="font-medium text-slate-900 dark:text-white">Ranting</li>
          </ol>
        </nav>
      </div>
      <div class="relative w-full md:w-64">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama ranting..."
          class="w-full rounded-lg border-slate-300 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
          <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
              clip-rule="evenodd" />
          </svg>
        </div>
      </div>
    </div>

    {{-- Grid Unit --}}
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @forelse($units as $unit)
        <a href="{{ route('public.athletes.by-unit', $unit) }}"
          class="group block rounded-xl border border-slate-200 bg-white p-6 shadow-sm hover:border-blue-500 hover:ring-1 hover:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 transition-all flex-col h-full">
          {{-- Added flex flex-col h-full agar footer kartu rata bawah --}}

          <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-blue-600 line-clamp-1">
              {{ $unit->name }}
            </h3>
            <span
              class="shrink-0 inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800 dark:bg-slate-700 dark:text-slate-300">
              {{ $unit->athletes_count }} Anggota
            </span>
          </div>

          <div class="mt-4 flex items-start gap-2 text-sm text-slate-600 dark:text-slate-400">
            <svg class="mt-0.5 size-4 shrink-0 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
            <span class="line-clamp-2">{{ $unit->address ?? 'Alamat tidak tersedia' }}</span>
          </div>

          {{-- BAGIAN BARU: NAMA PELATIH --}}
          <div class="mt-3 flex items-start gap-2 text-sm text-slate-600 dark:text-slate-400">
            <svg class="mt-0.5 size-4 shrink-0 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.875 1.875 0 0 1 18 22.5H6A1.875 1.875 0 0 1 4.501 20.118Z" />
            </svg>
            <span class="line-clamp-2">
              <span class="font-semibold text-slate-700 dark:text-slate-300">Dilatih oleh:</span>
              @if ($unit->coaches->isNotEmpty())
                {{ $unit->coaches->pluck('name')->join(', ') }}
              @else
                <span class="italic text-slate-400">Belum ada pelatih</span>
              @endif
            </span>
          </div>

          {{-- Spacer agar tombol selalu di bawah --}}
          <div class="grow"></div>

          <div class="mt-4 flex items-center justify-end border-t border-slate-100 dark:border-slate-700 pt-4">
            <span class="text-sm font-medium text-blue-600 group-hover:underline dark:text-blue-400">
              Lihat Anggota &rarr;
            </span>
          </div>
        </a>
      @empty
        <div class="col-span-full py-12 text-center text-slate-500">
          Tidak ada ranting yang ditemukan.
        </div>
      @endforelse
    </div>

    <div class="mt-6">
      {{ $units->links() }}
    </div>
  </div>
</div>
