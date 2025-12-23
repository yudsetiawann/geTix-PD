<section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-white/10 sm:p-8">

  {{-- Header Section --}}
  <header class="flex items-start gap-4 mb-8">
    <div
      class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="size-6">

        <path stroke-linecap="round" stroke-linejoin="round"
          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.875 1.875 0 0 1 18 22.5H6A1.875 1.875 0 0 1 4.501 20.118Z" />

      </svg>
    </div>
    <div>
      <h2 class="text-lg font-bold text-slate-900 dark:text-white">
        {{ __('Biodata Pengguna') }}
      </h2>
      <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
        {{ __('Lengkapi data diri Anda untuk keperluan verifikasi sistem.') }}
      </p>
    </div>
  </header>

  <form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
  </form>

  <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    {{-- GRID LAYOUT --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-2">

      {{-- 1. Nama Lengkap --}}
      <div class="col-span-1">
        <x-input-label for="name" :value="__('Nama Lengkap')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <x-text-input id="name" name="name" type="text"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('name', $user->name)" required autofocus autocomplete="name" />
        <x-input-error class="mt-2" :messages="$errors->get('name')" />
      </div>

      {{-- 2. NIK --}}
      <div class="col-span-1">
        <x-input-label for="nik" :value="__('Nomor Induk Kependudukan (NIK)')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <x-text-input id="nik" name="nik" type="text" maxlength="16"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('nik', $user->nik)" required />
        <x-input-error class="mt-2" :messages="$errors->get('nik')" />
      </div>

      {{-- 3. Email --}}
      <div class="col-span-1">
        <x-input-label for="email" :value="__('Email')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <x-text-input id="email" name="email" type="email"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('email', $user->email)" required autocomplete="username" />
        <x-input-error class="mt-2" :messages="$errors->get('email')" />
      </div>

      {{-- 4. No Telepon --}}
      <div class="col-span-1">
        <x-input-label for="phone" :value="__('Nomor WhatsApp')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <x-text-input id="phone" name="phone" type="text"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('phone', $user->phone_number ?? $user->phone)" required placeholder="08..." />
        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
      </div>

      {{-- 5. Tempat Lahir --}}
      <div class="col-span-1">
        <x-input-label for="place_of_birth" :value="__('Tempat Lahir')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <x-text-input id="place_of_birth" name="place_of_birth" type="text"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('place_of_birth', $user->place_of_birth)" required />
        <x-input-error class="mt-2" :messages="$errors->get('place_of_birth')" />
      </div>

      {{-- 6. Tanggal Lahir --}}
      <div class="col-span-1">
        <x-input-label for="date_of_birth" :value="__('Tanggal Lahir')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <x-text-input id="date_of_birth" name="date_of_birth" type="date"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d'))" required />
        <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
      </div>

      {{-- 7. Jenis Kelamin --}}
      <div class="col-span-1">
        <x-input-label for="gender" :value="__('Jenis Kelamin')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <select id="gender" name="gender"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white">
          <option value="" disabled {{ old('gender', $user->gender) ? '' : 'selected' }}>Pilih Jenis
            Kelamin
          </option>
          <option value="L" {{ old('gender', $user->gender) == 'L' ? 'selected' : '' }}>Laki-laki
          </option>
          <option value="P" {{ old('gender', $user->gender) == 'P' ? 'selected' : '' }}>Perempuan
          </option>
        </select>
        <x-input-error class="mt-2" :messages="$errors->get('gender')" />
      </div>

      {{-- 8. Pekerjaan --}}
      <div class="col-span-1">
        <x-input-label for="job" :value="__('Pekerjaan / Sekolah')" class="mb-1 text-gray-800 dark:text-gray-200" />
        {{-- PASTIKAN name="job" --}}
        <x-text-input id="job" name="job" type="text"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('job', $user->job)" required placeholder="Contoh: Pelajar, Mahasiswa, Karyawan" />
        <x-input-error class="mt-2" :messages="$errors->get('job')" />
      </div>

      {{-- 9. Alamat Domisili --}}
      <div class="col-span-1 md:col-span-2">
        <x-input-label for="address" :value="__('Alamat Domisili Lengkap')" class="mb-1 text-gray-800 dark:text-gray-200" />

        <textarea id="address" name="address" rows="3"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          required>{{ old('address', $user->address) }}</textarea>
        <x-input-error class="mt-2" :messages="$errors->get('address')" />

      </div>

      {{-- Divider Section Data Silat --}}
      <div class="col-span-1 md:col-span-2 mt-4 mb-2">
        <h3
          class="text-md font-bold text-slate-800 dark:text-slate-200 border-b pb-2 border-slate-200 dark:border-slate-700">
          Data Keanggotaan Perisai Diri
        </h3>
      </div>

      {{-- 10. Tingkatan & Tahun Masuk (Semua Role Butuh Ini) --}}
      <div class="col-span-1">
        <x-input-label for="level_id" :value="__('Tingkatan Saat Ini')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <select id="level_id" name="level_id"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white">
          <option value="">Pilih Tingkatan</option>

          {{-- Mengambil data level langsung dari Model --}}
          @foreach (\App\Models\Level::active()->get() as $lvl)
            <option value="{{ $lvl->id }}" {{ old('level_id', $user->level_id) == $lvl->id ? 'selected' : '' }}>
              {{ $lvl->name }}
            </option>
          @endforeach

        </select>
        <x-input-error class="mt-2" :messages="$errors->get('level_id')" />
      </div>

      <div class="col-span-1">
        <x-input-label for="join_year" :value="__('Tahun Masuk PD')" class="mb-1 text-gray-800 dark:text-gray-200" />
        <x-text-input id="join_year" name="join_year" type="number" min="1955" max="{{ date('Y') }}"
          class="block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white"
          :value="old('join_year', $user->join_year)" required />
        <x-input-error class="mt-2" :messages="$errors->get('join_year')" />
      </div>


      {{-- LOGIC SPLIT BERDASARKAN ROLE --}}
      @if ($user->isCoach())
        <div class="mt-2">
          <x-input-label for="organization_position_id" :value="__('Jabatan Struktur Organisasi')" class="text-gray-800 dark:text-gray-200" />
          {{-- <p class="text-xs text-gray-500 mb-2">Opsional, pilih jika Anda menjabat di pengurus cabang.</p> --}}

          <select id="organization_position_id" name="organization_position_id"
            class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-white">
            <option value="">-- Tidak Menjabat --</option>
            {{-- $positions diambil dari Controller edit() --}}
            @foreach ($positions as $position)
              <option value="{{ $position->id }}"
                {{ old('organization_position_id', $user->organization_position_id) == $position->id ? 'selected' : '' }}>
                {{ $position->name }}
              </option>
            @endforeach
          </select>
          <x-input-error class="mt-2" :messages="$errors->get('organization_position_id')" />
        </div>
        {{-- === INPUT KHUSUS PELATIH (MULTI SELECT DROPDOWN - FIXED) === --}}

        {{-- Kita siapkan datanya di PHP dulu agar kodingan HTML di bawah lebih rapi --}}
        @php
          $selectedUnits = old(
              'coached_units',
              $user->coachedUnits->pluck('id')->map(fn($id) => (string) $id)->toArray(),
          );
        @endphp

        {{-- PERHATIKAN: x-data dibungkus dengan kutip SATU ('...') agar aman dengan @json --}}
        <div class="col-span-1 md:col-span-2"
          x-data='{
             open: false,
             selected: @json($selectedUnits)
         }'>

          <x-input-label :value="__('Unit/Ranting Tempat Melatih')" class="mb-2 text-gray-800 dark:text-gray-200" />

          <div class="relative">
            {{-- 1. Trigger Button --}}
            <button type="button" @click="open = !open" @click.outside="open = false"
              class="flex w-full items-center justify-between rounded-lg border border-slate-300 bg-white px-3 py-2 text-left shadow-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white">

              {{-- Teks Dinamis: Logika dipindah ke sini menggunakan x-text langsung --}}
              <span class="block truncate"
                :class="selected.length === 0 ? 'text-slate-500 dark:text-slate-400' : 'text-slate-900 dark:text-white'"
                x-text="selected.length === 0 ? 'Pilih Unit/Ranting...' : selected.length + ' Unit Dipilih'">
              </span>

              <span class="pointer-events-none flex items-center pr-2">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd"
                    d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </span>
            </button>

            {{-- 2. Dropdown Content --}}
            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="transform opacity-0 scale-95"
              x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              class="absolute z-50 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none dark:bg-slate-800 dark:ring-slate-700 sm:text-sm">

              @foreach ($units as $unit)
                {{-- LOGIKA CEK KETERSEDIAAN --}}
                @php
                  // Cek apakah unit ini punya coach SELAIN user yang sedang login
                  $existingCoach = $unit->coaches->first(function ($coach) use ($user) {
                      return $coach->id !== $user->id;
                  });

                  $isTaken = !is_null($existingCoach);
                  $coachName = $isTaken ? $existingCoach->name : '';
                @endphp

                <label
                  class="relative flex cursor-pointer select-none items-center py-2 pl-3 pr-4
        {{ $isTaken ? ' opacity-75 cursor-not-allowed' : 'hover:bg-slate-100 dark:hover:bg-slate-700' }}">

                  <input type="checkbox" name="coached_units[]" value="{{ $unit->id }}" x-model="selected"
                    @if ($isTaken) disabled @endif
                    class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-600 dark:border-slate-600 dark:bg-slate-700
            {{ $isTaken ? 'text-slate-400 bg-slate-100' : '' }}">

                  <div class="ml-3 flex flex-col">
                    <span
                      class="block truncate font-normal {{ $isTaken ? 'text-slate-500 italic decoration-slate-400' : 'text-slate-900 dark:text-slate-200' }}">
                      {{ $unit->name }}
                    </span>

                    {{-- Tampilkan Info jika sudah diambil --}}
                    @if ($isTaken)
                      <span class="text-[10px] text-red-500 font-medium">
                        (Dilatih oleh: {{ $coachName }})
                      </span>
                    @endif
                  </div>
                </label>
              @endforeach

              @if ($units->isEmpty())
                <div class="px-4 py-2 text-sm text-slate-500">Tidak ada data unit.</div>
              @endif
            </div>
          </div>

          <p class="mt-1 text-xs text-slate-500">Klik kolom di atas untuk memilih unit.</p>
          <x-input-error class="mt-2" :messages="$errors->get('coached_units')" />
        </div>
      @else
        {{-- === INPUT KHUSUS ATLET / USER BIASA === --}}

        {{-- Unit Asal --}}
        <div class="col-span-1">
          <x-input-label for="unit_asal_id" :value="__('Unit/Ranting Asal')" class="mb-1 text-gray-800 dark:text-gray-200" />
          <select id="unit_asal_id" name="unit_asal_id"
            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
            <option value="">Pilih Unit Asal</option>
            @foreach ($units as $unit)
              <option value="{{ $unit->id }}"
                {{ old('unit_asal_id', $user->unit_id) == $unit->id ? 'selected' : '' }}>
                {{ $unit->name }}
              </option>
            @endforeach
          </select>
          <x-input-error class="mt-2" :messages="$errors->get('unit_asal_id')" />
        </div>

        {{-- Unit Latihan (Trigger Verifikasi) --}}
        <div class="col-span-1">
          <x-input-label for="unit_id" :value="__('Unit Tempat Latihan (Untuk Verifikasi)')" class="mb-1 text-gray-800 dark:text-gray-200" />
          <select id="unit_latihan_id" name="unit_latihan_id"
            class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white">
            <option value="">Pilih Unit Latihan</option>
            @foreach ($units as $unit)
              {{-- Ubah logic old() dan selected agar sesuai --}}
              <option value="{{ $unit->id }}"
                {{ old('unit_latihan_id', $user->unit_id) == $unit->id ? 'selected' : '' }}>
                {{ $unit->name }}
              </option>
            @endforeach
          </select>

          <p class="mt-1 text-xs text-amber-600 dark:text-amber-400">
            *Pelatih unit ini akan memverifikasi data Anda.
          </p>
          {{-- Ubah error get --}}
          <x-input-error class="mt-2" :messages="$errors->get('unit_latihan_id')" />
        </div>
      @endif

    </div>

    {{-- Footer & Verifikasi Email --}}
    <div class="col-span-1 md:col-span-2">
      @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div
          class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-900/20">
          <p class="text-sm text-amber-800 dark:text-amber-200">
            {{ __('Alamat email Anda belum diverifikasi.') }}
            <button form="send-verification" class="underline hover:text-amber-900">
              {{ __('Klik kirim ulang.') }}
            </button>
          </p>
          @if (session('status') === 'verification-link-sent')
            <p class="mt-2 text-sm font-semibold text-green-600">{{ __('Tautan baru terkirim.') }}</p>
          @endif
        </div>
      @endif
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center gap-4 border-t border-slate-100 pt-6 dark:border-slate-700">
      <x-primary-button class="px-6 py-2.5">
        {{ __('Simpan Perubahan') }}
      </x-primary-button>

      @if (session('status') === 'profile-updated')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
          class="flex items-center gap-2 text-sm font-medium text-green-600 dark:text-green-400">
          <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">

            <path fill-rule="evenodd"
              d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
              clip-rule="evenodd" />

          </svg>
          {{ __('Data berhasil disimpan.') }}
        </div>
      @endif
    </div>
  </form>
</section>
