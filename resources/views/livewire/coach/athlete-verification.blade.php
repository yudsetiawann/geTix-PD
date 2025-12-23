<div class="py-12">
  <div class="pt-8 max-w-7xl mx-auto px-5 sm:px-6 lg:px-8">

    {{-- Header Section --}}
    <div class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
      <div>
        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
          Verifikasi Atlet
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Tinjau dan validasi pendaftaran atlet yang masuk.
        </p>
      </div>
      <div
        class="flex items-center space-x-2 bg-white dark:bg-gray-800 px-4 py-2 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
        <span class="text-xs font-medium text-gray-500 uppercase">Unit Binaan:</span>
        <span class="text-sm font-semibold text-blue-700 dark:text-blue-400">
          {{ Auth::user()->coachedUnits->pluck('name')->join(', ') }}
        </span>
      </div>
    </div>

    {{-- Flash Messages (MODIFIED: Floating Toast Style) --}}

    {{-- 1. Success Message --}}
    @if (session()->has('message'))
      <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" x-init="setTimeout(() => show = false, 5000)"
        class="fixed top-24 right-5 z-50 w-full max-w-sm bg-white dark:bg-gray-800 border-l-4 border-green-500 shadow-xl rounded-lg overflow-hidden pointer-events-auto ring-1 ring-black ring-opacity-5"
        style="display: none;" {{-- Mencegah flicker saat load --}}>
        <div class="p-4">
          <div class="flex items-start">
            <div class="shrink-0">
              <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Berhasil!</p>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ session('message') }}
              </p>
            </div>
            <div class="ml-4 flex shrink-0">
              <button @click="show = false" type="button"
                class="inline-flex rounded-md bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path
                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- 2. Error Message --}}
    @if (session()->has('error'))
      <div x-data="{ show: true }" x-show="show" x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed top-24 right-5 z-50 w-full max-w-sm bg-white dark:bg-gray-800 border-l-4 border-red-500 shadow-xl rounded-lg overflow-hidden pointer-events-auto ring-1 ring-black ring-opacity-5"
        style="display: none;">
        <div class="p-4">
          <div class="flex items-start">
            <div class="shrink-0">
              <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
              </svg>
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
              <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Gagal</p>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ session('error') }}
              </p>
            </div>
            <div class="ml-4 flex shrink-0">
              <button @click="show = false" type="button"
                class="inline-flex rounded-md bg-white dark:bg-gray-800 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <span class="sr-only">Close</span>
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path
                    d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
    @endif

    {{-- Main Content Area --}}
    <div
      class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">

      @if ($athletes->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
          <div class="bg-gray-100 dark:bg-gray-700 rounded-full p-4 mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
              </path>
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tidak ada permintaan</h3>
          <p class="text-gray-500 dark:text-gray-400 mt-1">Belum ada atlet baru yang menunggu verifikasi saat ini.</p>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-900/50">
              <tr>
                <th scope="col"
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Profil Atlet
                </th>
                <th scope="col"
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Afiliasi &
                  Tingkat</th>
                <th scope="col"
                  class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Informasi
                  Kontak</th>
                <th scope="col"
                  class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Keputusan
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
              @foreach ($athletes as $athlete)
                <tr wire:key="athlete-{{ $athlete->id }}"
                  class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out group">

                  {{-- Kolom Profil --}}
                  <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex items-center">
                      <div class="shrink-0 h-10 w-10">
                        <div
                          class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm ring-2 ring-white dark:ring-gray-800">
                          {{ substr($athlete->name, 0, 2) }}
                        </div>
                      </div>
                      <div class="ml-4">
                        <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $athlete->name }}</div>
                        <div class="text-sm text-gray-500">{{ $athlete->email }}</div>
                      </div>
                    </div>
                  </td>

                  {{-- Kolom Unit & Level --}}
                  <td class="px-6 py-5 whitespace-nowrap">
                    <div class="flex flex-col space-y-2 items-start">
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                        {{ $athlete->unit->name ?? 'Tanpa Unit' }}
                      </span>
                      <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
                        <span class="font-medium mr-1">{{ $athlete->level?->name ?? '-' }}</span>
                        <span class="text-gray-400 text-xs mx-1">•</span>
                        <span class="text-xs text-gray-500">Sejak {{ $athlete->join_year }}</span>
                      </div>
                    </div>
                  </td>

                  {{-- Kolom Data Diri (Icons) --}}
                  <td class="px-6 py-5">
                    <div class="flex flex-col space-y-1.5 text-sm text-gray-600 dark:text-gray-400">
                      <div class="flex items-center" title="Tempat, Tanggal Lahir">
                        <svg class="shrink-0 mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                          </path>
                        </svg>
                        <span class="truncate">{{ $athlete->place_of_birth }},
                          {{ $athlete->date_of_birth?->format('d M Y') }}</span>
                      </div>
                      <div class="flex items-center" title="Jenis Kelamin">
                        <svg class="shrink-0 mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ $athlete->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                      </div>
                      <div class="flex items-center" title="WhatsApp">
                        <svg class="shrink-0 mr-2 h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                          </path>
                        </svg>
                        <span class="font-mono text-xs">{{ $athlete->phone_number }}</span>
                      </div>
                    </div>
                  </td>

                  {{-- Kolom Aksi --}}
                  <td class="px-6 py-5 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end space-x-3">
                      <button wire:click="openRejectModal('{{ $athlete->id }}')"
                        class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 dark:hover:bg-red-900/20"
                        title="Tolak">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                      </button>

                      <button wire:click="approve('{{ $athlete->id }}')"
                        wire:confirm="Yakin data atlet ini sudah valid?"
                        class="inline-flex items-center px-3 py-1.5 border border-transparent shadow-sm text-xs font-semibold rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                        <svg class="-ml-0.5 mr-1.5 h-4 w-4" fill="none" stroke="currentColor"
                          viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                          </path>
                        </svg>
                        Terima
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        {{-- Pagination dengan border atas --}}
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
          {{ $athletes->links() }}
        </div>
      @endif
    </div>
  </div>

  {{-- Modal Reject (Refined & Teleported) --}}
  @if ($showRejectModal)
    @teleport('body')
      {{-- Wrapper Utama: Z-Index tinggi agar di atas segalanya --}}
      <div class="fixed inset-0 z-9999 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">

        {{-- Flex container untuk centering --}}
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

          {{-- 1. Backdrop Gelap & Blur --}}
          <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity" aria-hidden="true"
            wire:click="$set('showRejectModal', false)"></div>

          {{-- Spacer agar modal ada di tengah vertikal --}}
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

          {{-- 2. Panel Modal (Kotaknya) --}}
          <div
            class="relative inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-200 dark:border-gray-700">

            {{-- Header & Form --}}
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
              <div class="sm:flex sm:items-start">

                {{-- Icon Peringatan --}}
                <div
                  class="mx-auto shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/50 sm:mx-0 sm:h-10 sm:w-10">
                  <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                  </svg>
                </div>

                {{-- Konten Text --}}
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                  <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-gray-100" id="modal-title">
                    Tolak Verifikasi
                  </h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
                      Berikan alasan kenapa data atlet ini ditolak.
                    </p>

                    {{-- Textarea Input --}}
                    <div class="relative">
                      <textarea wire:model="rejectionNote"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-200 placeholder-gray-400 p-3"
                        rows="4" placeholder="Contoh: Foto profil buram, Tanggal lahir tidak sesuai KTP..."></textarea>
                    </div>

                    @error('rejectionNote')
                      <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
              </div>
            </div>

            {{-- Footer Tombol --}}
            <div
              class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2 border-t border-gray-100 dark:border-gray-700">
              <button type="button" wire:click="reject" wire:loading.attr="disabled"
                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:w-auto sm:text-sm disabled:opacity-50 transition-colors">
                <span wire:loading.remove wire:target="reject">Kirim Penolakan</span>
                <span wire:loading wire:target="reject">Mengirim...</span>
              </button>

              <button type="button" wire:click="$set('showRejectModal', false)"
                class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transition-colors">
                Batal
              </button>
            </div>
          </div>
        </div>
      </div>
    @endteleport
  @endif
</div>
