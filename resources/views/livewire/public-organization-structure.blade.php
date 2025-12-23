<div class="py-12 min-h-screen">
  <div class="pt-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="text-center mb-8"> {{-- Margin bottom dikurangi sedikit --}}
      <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
        Struktur Organisasi
      </h2>
      <p class="mt-4 text-xl text-gray-500 dark:text-gray-400">
        Pengurus Unit Perisai Diri Kabupaten Tasikmalaya
      </p>
      <p class="text-sm text-blue-500 mt-2 animate-pulse">
        (Klik pada kartu untuk melihat detail profil & lokasi melatih)
      </p>
    </div>

    {{-- SEARCH BAR (BARU) --}}
    <div class="max-w-xl mx-auto mb-10 relative">
      <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          {{-- Icon Search --}}
          <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
            aria-hidden="true">
            <path fill-rule="evenodd"
              d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
              clip-rule="evenodd" />
          </svg>
        </div>
        <input wire:model.live.debounce.300ms="search" type="text"
          class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white dark:bg-slate-800 dark:border-gray-700 dark:text-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-150 ease-in-out shadow-sm"
          placeholder="Cari nama anggota atau jabatan...">

        {{-- Loading Indicator untuk Search --}}
        <div wire:loading wire:target="search" class="absolute inset-y-0 right-0 top-2 pr-3 flex items-center">
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

    {{-- Grid Card --}}
    @if ($members->isEmpty())
      {{-- TAMPILAN JIKA TIDAK ADA HASIL --}}
      <div class="text-center py-12">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
          <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada anggota ditemukan</h3>
        <p class="mt-1 text-gray-500 dark:text-gray-400">Coba kata kunci pencarian yang lain.</p>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($members as $member)
          <div wire:key="member-{{ $member->id }}" wire:click="openProfile({{ $member->id }})"
            class="group bg-white dark:bg-slate-900 rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-800 hover:shadow-2xl hover:border-blue-400 dark:hover:border-blue-600 transition-all duration-300 transform hover:-translate-y-2 cursor-pointer relative">

            {{-- Loading Indicator per Card --}}
            <div wire:loading wire:target="openProfile({{ $member->id }})"
              class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 flex items-center justify-center z-10 backdrop-blur-sm">
              <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
              </svg>
            </div>

            <div class="p-6 text-center">
              <div
                class="mx-auto h-24 w-24 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-3xl font-bold mb-4 ring-4 ring-blue-50 dark:ring-blue-900/20 group-hover:scale-110 transition-transform duration-300">
                {{ substr($member->name, 0, 2) }}
              </div>
              <h3 class="text-lg font-bold text-blue-600 dark:text-blue-400 mb-1">
                {{ $member->organizationPosition?->name ?? '-' }}
              </h3>
              <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                {{ $member->name }}
              </h4>
              <span class="inline-flex items-center text-xs font-medium text-gray-400">
                Lihat Detail &rarr;
              </span>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  {{-- MODAL DETAIL PROFILE --}}
  {{-- Kita cek variabel computed $this->selectedMember --}}
  @if ($showModal && $this->selectedMember)
    <div x-data="{ open: true }" x-show="open" x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
      x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
      role="dialog" aria-modal="true">

      <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        {{-- Backdrop --}}
        {{-- @click="open = false" membuat modal hilang INSTAN secara visual --}}
        {{-- $wire.closeProfile() memanggil server di background untuk cleanup --}}
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm"
          @click="open = false; $wire.closeProfile()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        {{-- Modal Panel --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave="transition ease-in duration-200"
          x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
          x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          class="relative z-50 inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-200 dark:border-gray-700">

          {{-- Header Modal --}}
          <div class="bg-linear-to-r from-blue-600 to-indigo-700 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
              Profil Pengurus
            </h3>
            <button type="button" @click="open = false; $wire.closeProfile()"
              class="text-white/70 hover:text-white transition-colors focus:outline-none">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
              </svg>
            </button>
          </div>

          <div class="px-6 py-6">
            <div class="flex flex-col sm:flex-row gap-6">
              {{-- Kolom Kiri --}}
              <div
                class="sm:w-1/3 flex flex-col items-center text-center border-b sm:border-b-0 sm:border-r border-gray-100 dark:border-gray-700 pb-6 sm:pb-0 sm:pr-6">
                <div
                  class="h-28 w-28 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-3xl font-bold mb-4 ring-4 ring-white dark:ring-gray-700 shadow-md">
                  {{ substr($this->selectedMember->name, 0, 2) }}
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white leading-tight">
                  {{ $this->selectedMember->name }}
                </h2>
                <p class="text-sm text-blue-600 dark:text-blue-400 font-medium mt-1">
                  {{ $this->selectedMember->organizationPosition?->name }}
                </p>
              </div>

              {{-- Kolom Kanan --}}
              <div class="sm:w-2/3">
                <h4
                  class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 border-b border-gray-100 dark:border-gray-700 pb-2">
                  Informasi Anggota
                </h4>

                <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2 mb-6">
                  <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Tingkatan/Sabuk</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                      {{ $this->selectedMember->level?->name ?? 'Strip Putih' }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Tahun Bergabung</dt>
                    <dd class="text-sm font-medium text-gray-900 dark:text-white">
                      {{ $this->selectedMember->join_year ?? '-' }}
                    </dd>
                  </div>
                  <div>
                    <dt class="text-xs text-gray-500 dark:text-gray-400">Status</dt>
                    <dd
                      class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                      Aktif
                    </dd>
                  </div>
                </dl>

                <h4
                  class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-3 border-b border-gray-100 dark:border-gray-700 pb-2 flex items-center gap-2">
                  Lokasi Melatih (Unit Binaan)
                </h4>

                <div class="flex flex-wrap gap-2">
                  @if ($this->selectedMember->coachedUnits && $this->selectedMember->coachedUnits->count() > 0)
                    @foreach ($this->selectedMember->coachedUnits as $unit)
                      <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100 dark:bg-blue-900/30 dark:text-blue-300 dark:border-blue-800">
                        {{ $unit->name }}
                      </span>
                    @endforeach
                  @else
                    <p class="text-sm text-gray-500 italic">
                      Belum ada data unit binaan.
                    </p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- Footer Modal --}}
          <div class="bg-gray-50 dark:bg-gray-700/50 px-6 py-3 sm:flex sm:flex-row-reverse">
            <button type="button" @click="open = false; $wire.closeProfile()"
              class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-200 dark:border-gray-600 dark:hover:bg-gray-700 transition-colors">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
