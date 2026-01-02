<div class="py-12 px-5">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- Header & Breadcrumb Dinamis --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
          {{ $pageTitle ?? 'Daftar Anggota' }}
        </h2>

        {{-- Breadcrumb Navigasi --}}
        <nav class="flex text-sm text-slate-500 dark:text-slate-400 mt-1" aria-label="Breadcrumb">
          <ol class="flex items-center space-x-2">
            <li><a href="{{ route('public.menu') }}" class="hover:text-blue-600">Direktori</a></li>
            <li><span class="text-slate-400">/</span></li>

            @if (isset($unit) && $unit->exists)
              <li><a href="{{ route('public.units') }}" class="hover:text-blue-600">Ranting</a></li>
              <li><span class="text-slate-400">/</span></li>
              <li class="font-medium text-slate-900 dark:text-white">{{ $unit->name }}</li>
            @else
              <li class="font-medium text-slate-900 dark:text-white">Semua Anggota</li>
            @endif
          </ol>
        </nav>
      </div>

      {{-- Search Input --}}
      <div class="relative w-full md:w-64">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama / NIA..."
          class="w-full rounded-lg border-slate-300 pl-10 text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
          <svg class="h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              clip-rule="evenodd" />
          </svg>
        </div>
      </div>
    </div>

    {{-- Grid / List Atlet --}}
    @if ($athletes->isEmpty())
      <div
        class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center dark:border-slate-700 dark:bg-slate-800/50">
        <svg class="mx-auto h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
        </svg>
        <h3 class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">Tidak ada anggota ditemukan</h3>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Coba ubah kata kunci pencarian atau filter Anda.</p>
      </div>
    @else
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($athletes as $athlete)
          <div
            class="group relative flex flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition-all hover:border-blue-500 hover:shadow-md dark:border-slate-700 dark:bg-slate-800">

            {{-- Badge Level/Sabuk --}}
            <div class="absolute right-3 top-3">
              <span
                class="inline-flex items-center rounded-full bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-900/30 dark:text-blue-400">
                {{ $athlete->level->name ?? 'Anggota' }}
              </span>
            </div>

            <div class="p-6">
              {{-- Avatar / Inisial --}}
              <div
                class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-lg font-bold text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                {{ strtoupper(substr($athlete->name, 0, 2)) }}
              </div>

              <h3 class="text-base font-semibold text-slate-900 dark:text-white group-hover:text-blue-600">
                {{ $athlete->name }}
              </h3>

              <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                NIA: {{ $athlete->nia ?? '-' }}
              </p>

              <div class="mt-4 border-t border-slate-100 pt-4 dark:border-slate-700">
                <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                  <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                  </svg>
                  <span class="line-clamp-1">{{ $athlete->unit->name ?? 'Unit tidak diketahui' }}</span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <div class="mt-6">
        {{ $athletes->links() }}
      </div>
    @endif
  </div>
</div>
