<div class="py-12 min-h-screen">
  <div class="pt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- Header & Search --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
      <div>
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
          Daftar Anggota Resmi
        </h2>
        <p class="mt-1 text-gray-500 dark:text-gray-400">
          Cari data anggota aktif Perisai Diri berdasarkan nama atau unit latihan.
        </p>
      </div>

      <div class="relative w-full md:w-96">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              clip-rule="evenodd" />
          </svg>
        </div>
        {{-- Input Search Real-time --}}
        <input wire:model.live.debounce.300ms="search" type="text"
          class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-slate-900 text-gray-900 dark:text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm shadow-sm transition duration-150 ease-in-out"
          placeholder="Cari nama atau unit...">
        {{-- Loading Indicator (Optional) --}}
        <div wire:loading class="absolute inset-y-0 right-0 top-2 pr-3 flex items-center">
          <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
            </circle>
            <path class="opacity-75" fill="currentColor"
              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
          </svg>
        </div>
      </div>
    </div>

    {{-- Content Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse ($athletes as $athlete)
        <div
          class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6 flex items-center space-x-4 hover:shadow-md transition-shadow duration-300">
          {{-- Avatar Inisial --}}
          <div class="shrink-0">
            <div
              class="h-12 w-12 rounded-full bg-linear-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
              {{ substr($athlete->name, 0, 2) }}
            </div>
          </div>

          {{-- Info Anggota --}}
          <div class="min-w-0 flex-1">
            <p class="text-base font-semibold text-gray-900 dark:text-white truncate">
              {{ $athlete->name }}
            </p>
            <div class="flex flex-col mt-1">
              {{-- Menampilkan Unit --}}
              <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                <svg class="h-4 w-4 text-gray-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                  </path>
                </svg>
                <span class="truncate">{{ $athlete->unit->name ?? 'Tanpa Unit' }}</span>
              </div>
            </div>
          </div>
        </div>
      @empty
        {{-- Empty State --}}
      @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
      {{ $athletes->links() }}
    </div>
  </div>
</div>
