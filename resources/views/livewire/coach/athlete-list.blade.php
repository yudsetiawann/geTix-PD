<div class="py-12 px-5">
  <div class="pt-8 px-5 max-w-7xl mx-auto sm:px-6 lg:px-8">

    {{-- LOGIC UTAMA: TAMPILAN UNIT LIST vs ATLET LIST --}}

    @if (!$selectedUnitId)
      {{-- === TAMPILAN 1: GRID UNIT / RANTING === --}}

      <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
          Pilih Unit Latihan
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
          Silakan pilih unit di bawah ini untuk melihat daftar atlet.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($units as $unit)
          <div wire:click="selectUnit({{ $unit->id }}, '{{ $unit->name }}')"
            class="group cursor-pointer bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200">

            <div class="p-6 flex items-start justify-between">
              <div>
                <h3
                  class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                  {{ $unit->name }}
                </h3>
                <p class="text-sm text-gray-500 mt-1">
                  {{ $unit->address ?? 'Alamat belum diisi' }}
                </p>
              </div>
              <div class="bg-blue-50 dark:bg-blue-900/30 p-3 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
            </div>

            <div
              class="bg-gray-50 dark:bg-gray-700/50 px-6 py-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
              <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Total Atlet Aktif</span>
              <span
                class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                {{ $unit->active_athletes_count }} Orang
              </span>
            </div>
          </div>
        @empty
          <div
            class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada unit binaan</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda belum ditugaskan melatih di unit manapun.</p>
          </div>
        @endforelse
      </div>
    @else
      {{-- === TAMPILAN 2: DAFTAR ATLET (TABLE) === --}}

      {{-- Header & Search & Back Button --}}
      <div class="flex flex-col gap-4 mb-6">

        {{-- Tombol Kembali --}}
        <div>
          <button wire:click="backToUnits"
            class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-blue-400 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar Unit
          </button>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-end sm:items-center gap-4">
          <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
              Unit: {{ $selectedUnitName }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              Daftar atlet aktif di unit ini.
            </p>
          </div>

          {{-- Search Input (Hanya mencari di unit ini) --}}
          <div class="relative w-full sm:w-64">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari atlet di unit ini..."
              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>

      {{-- Table Content --}}
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Atlet
                </th>
                {{-- Kolom Unit Latihan dihapus/hidden karena sudah difilter per unit --}}
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkatan
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
              @forelse($athletes as $athlete)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="h-10 w-10 shrink-0 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-sm">
                        {{ substr($athlete->name, 0, 2) }}
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                          {{ $athlete->name }}
                        </div>
                        <div class="text-xs text-gray-500">
                          NIK: {{ $athlete->nik ?? '-' }}
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <span
                      class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-800 border border-slate-200">
                      {{ $athlete->level->name ?? '-' }}
                    </span>
                    <div class="text-xs text-gray-500 mt-1">Th. {{ $athlete->join_year }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    <div class="flex flex-col text-xs">
                      <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $athlete->phone_number)) }}"
                        target="_blank" class="text-green-600 hover:text-green-800 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                          <path
                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                        </svg>
                        {{ $athlete->phone_number }}
                      </a>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-center">
                    <span
                      class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                      Aktif
                    </span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                      <p>Tidak ada atlet yang ditemukan di unit ini.</p>
                    </div>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
          {{ $athletes->links() }}
        </div>
      </div>

    @endif

  </div>
</div>
