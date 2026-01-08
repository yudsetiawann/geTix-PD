<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 relative z-20">

  {{-- CASE 1: PELATIH BELUM LENGKAP --}}
  @if ($status === 'incomplete_coach')
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-md animate-fade-in-down">
      <div class="flex">
        <div class="shrink-0">
          <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
              clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-yellow-800">Profil Pelatih Belum Lengkap</h3>
          <div class="mt-2 text-sm text-yellow-700">
            <p>Halo Pelatih <strong>{{ $user->name }}</strong>. Anda belum menentukan <strong>Unit
                Latihan</strong>. Silakan lengkapi profil.</p>
          </div>
          <div class="mt-4">
            <a href="{{ route('profile.edit') }}"
              class="text-sm font-medium text-yellow-800 hover:text-yellow-900 hover:underline">Lengkapi
              Profil Sekarang →</a>
          </div>
        </div>
      </div>
    </div>

    {{-- CASE 2: ATLET BELUM PILIH UNIT --}}
  @elseif ($status === 'incomplete_athlete')
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-md animate-fade-in-down">
      <div class="flex">
        <div class="shrink-0">
          <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
              clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-yellow-800">Lengkapi Profil Anda</h3>
          <div class="mt-2 text-sm text-yellow-700">
            <p>Silakan pilih <strong>Unit Latihan</strong> di menu edit profil.</p>
          </div>
          <div class="mt-4"><a href="{{ route('profile.edit') }}"
              class="text-sm font-medium text-yellow-800 hover:text-yellow-900 hover:underline">Lengkapi
              Profil →</a></div>
        </div>
      </div>
    </div>

    {{-- CASE 3: VERIFIKASI DITOLAK --}}
  @elseif ($status === 'rejected')
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-md animate-pulse">
      <div class="flex">
        <div class="shrink-0"><svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
            fill="currentColor">
            <path fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
              clip-rule="evenodd" />
          </svg></div>
        <div class="ml-3 w-full">
          <h3 class="text-sm font-medium text-red-800">Verifikasi Ditolak</h3>
          <div class="mt-2 text-sm text-red-700">
            <p>Pengajuan verifikasi ditolak. Alasan: "{{ $rejectionNote }}"</p>
          </div>
          <div class="mt-4"><a href="{{ route('profile.edit') }}"
              class="text-sm font-medium text-red-800 hover:text-red-900 hover:underline">Perbaiki Data
              →</a></div>
        </div>
      </div>
    </div>

    {{-- CASE 4: MENUNGGU VERIFIKASI --}}
  @elseif ($status === 'pending')
    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg shadow-md">
      <div class="flex">
        <div class="shrink-0"><svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
              d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
              clip-rule="evenodd" />
          </svg></div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-blue-800">Menunggu Verifikasi</h3>
          <div class="mt-2 text-sm text-blue-700">
            <p>Data Anda sedang ditinjau oleh pelatih unit <strong>{{ $unitName }}</strong>.</p>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
