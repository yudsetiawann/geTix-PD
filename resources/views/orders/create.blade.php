<x-app-layout title="Pesan Tiket: {{ $event->title }}">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
      Form Pemesanan
    </h1>
  </x-slot>

  @php
    // Ambil data user yang sedang login
    $user = auth()->user();
    // Ambil nama level/sabuk user (misal: "Dasar I")
    $userLevelName = $user->level ? $user->level->name : '';
    $userUnitName = $user->unit ? $user->unit->name : '-';
  @endphp

  {{-- Kontainer Utama --}}
  <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">

    {{-- Alpine.js Data Context --}}
    <div x-data="{
        // Data dari Controller
        eventType: '{{ $eventType }}',
        basePrice: {{ $event->ticket_price ?? 0 }},
        levelPrices: {{ json_encode($levelPrices) ?? '{}' }},
        hasDynamicPricing: {{ $hasDynamicPricing ? 'true' : 'false' }},

        // Input state (Auto-fill dari Profile User)
        selectedLevel: '{{ $userLevelName }}', // Otomatis terisi Sabuk User
        selectedCompetitionLevel: '{{ old('competition_level', '') }}', // Editable
        selectedCategory: '{{ old('category', '') }}', // Editable
        quantity: 1,

        // Hasil Kalkulasi
        calculatedPrice: 0,

        // Hitung harga
        calculatePrice() {
            if (!this.hasDynamicPricing) {
                this.calculatedPrice = this.basePrice;
                return;
            }

            let price = 0;
            if (this.eventType === 'ujian' && this.selectedLevel) {
                // Logika Harga Ujian berdasarkan Sabuk User saat ini
                if (['Pemula', 'Dasar I'].includes(this.selectedLevel)) {
                    price = this.levelPrices?.pemula_dasar1 ?? 0;
                } else if (this.selectedLevel === 'Dasar II') {
                    price = this.levelPrices?.dasar2 ?? 0;
                } else if (this.selectedLevel === 'Cakel') {
                    price = this.levelPrices?.cakel ?? 0;
                } else if (this.selectedLevel === 'Putih') {
                    price = this.levelPrices?.putih ?? 0;
                } else if (this.selectedLevel === 'Putih Hijau') {
                    price = this.levelPrices?.putih_hijau ?? 0;
                } else if (this.selectedLevel === 'Hijau') {
                    price = this.levelPrices?.hijau ?? 0;
                }
            } else if (this.eventType === 'pertandingan' && this.selectedCategory) {
                const categoryKey = this.selectedCategory.toLowerCase().replace(' ', '_');
                price = this.levelPrices?.[categoryKey] ?? 0;
            }
            this.calculatedPrice = price;
        },
        formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
        }
    }" x-init="calculatePrice()" class="mx-auto max-w-2xl">
      {{-- Akhir div x-data --}}

      {{-- Tampilkan error session --}}
      @if (session('error'))
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/50">
          <div class="flex">
            <div class="shrink-0">
              <svg class="size-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1.75-4.5a.75.75 0 0 0 1.5 0v-2.5a.75.75 0 0 0-1.5 0v2.5ZM10 10a.75.75 0 0 0-1.5 0v.01a.75.75 0 0 0 1.5 0V10Z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
            </div>
          </div>
        </div>
      @endif

      {{-- Tampilkan validasi error --}}
      @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/50">
          <div class="flex">
            <div class="shrink-0">
              <svg class="size-5 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                  d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1.75-4.5a.75.75 0 0 0 1.5 0v-2.5a.75.75 0 0 0-1.5 0v2.5ZM10 10a.75.75 0 0 0-1.5 0v.01a.75.75 0 0 0 1.5 0V10Z"
                  clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Terjadi Kesalahan:</h3>
              <ul class="mt-2 list-disc pl-5 text-sm text-red-700 dark:text-red-300">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      @endif

      {{-- Bagian 1: Ringkasan Event (Read-only) --}}
      <div class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800">
        <div class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/50 sm:px-6">
          <h2 class="text-base font-semibold leading-6 text-slate-900 dark:text-white">Ringkasan Event</h2>
        </div>
        <div class="p-4 sm:px-6">
          <h3 class="text-lg font-bold text-slate-900 dark:text-white">{{ $event->title }}</h3>
          <div class="mt-2 flex flex-col gap-y-1 text-sm text-slate-600 dark:text-slate-400 sm:flex-row sm:gap-x-4">
            <p class="flex items-center">
              <svg class="mr-1.5 size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
              </svg>
              {{ $event->location }}
            </p>
            <p class="flex items-center">
              <svg class="mr-1.5 size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
              </svg>
              {{ $event->starts_at->format('d M Y') }}
            </p>
          </div>
        </div>
      </div>

      {{-- Form Utama --}}
      <form action="{{ route('orders.store', $event) }}" method="POST" class="mt-8 space-y-8">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        {{-- Bagian 2: Detail Peserta (AUTO FILL FROM PROFILE) --}}
        <div
          class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800">
          <div class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/50 sm:px-6">
            <h2 class="text-base font-semibold leading-6 text-slate-900 dark:text-white">Detail Peserta (Sesuai Profil)
            </h2>
          </div>
          <div class="space-y-6 p-4 sm:p-6">

            {{-- Nama (Read Only) --}}
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nama Lengkap</label>
              <input type="text" value="{{ $user->name }}" readonly
                class="mt-1 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
              {{-- Hidden input jika controller membutuhkan, tapi idealnya controller pakai Auth::user() --}}
              <input type="hidden" name="customer_name" value="{{ $user->name }}">
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
              {{-- Tempat Lahir (Read Only) --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tempat Lahir</label>
                <input type="text" value="{{ $user->place_of_birth }}" readonly
                  class="mt-1 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                <input type="hidden" name="birth_place" value="{{ $user->place_of_birth }}">
              </div>
              {{-- Tanggal Lahir (Read Only) --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                <input type="text" value="{{ $user->date_of_birth ? $user->date_of_birth->format('d M Y') : '-' }}"
                  readonly
                  class="mt-1 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                <input type="hidden" name="birth_date" value="{{ $user->date_of_birth }}">
              </div>
            </div>

            <div x-show="eventType === 'pertandingan'" class="space-y-6">
              {{-- NIK (Read Only) --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIK</label>
                <input type="text" value="{{ $user->nik }}" readonly
                  class="mt-1 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                <input type="hidden" name="nik" value="{{ $user->nik }}">
              </div>

              {{-- Berat Badan (EDITABLE - Exception) --}}
              <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                <div>
                  <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Berat
                    Badan (Kg)</label>
                  <input type="number" name="weight" id="weight" :required="eventType === 'pertandingan'"
                    class="mt-1 block w-full rounded-lg border-slate-300 bg-white shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500">
                </div>
              </div>
            </div>

            {{-- No. Telp (Read Only) --}}
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nomor Telepon</label>
              <input type="text" value="{{ $user->phone_number }}" readonly
                class="mt-1 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
              <input type="hidden" name="phone_number" value="{{ $user->phone_number }}">
            </div>

            {{-- Ranting / Unit (Read Only) --}}
            <div>
              <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Ranting / Sekolah</label>
              <input type="text" value="{{ $userUnitName }}" readonly
                class="mt-1 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
              <input type="hidden" name="school" value="{{ $userUnitName }}">
            </div>

            {{-- Bagian Grid Dinamis --}}
            <div class="grid gap-6"
              :class="eventType === 'pertandingan' ? 'grid-cols-1 sm:grid-cols-3' : 'grid-cols-1'">

              {{-- 1. Tingkatan SABUK (Read Only from Profile) --}}
              <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                  Tingkatan (Sabuk)
                </label>
                {{-- Tampilan Read-only --}}
                <input type="text" value="{{ $userLevelName }}" readonly
                  class="mt-1 block w-full cursor-not-allowed rounded-lg border-slate-200 bg-slate-100 text-slate-500 shadow-sm focus:border-slate-200 focus:ring-0 dark:border-slate-700 dark:bg-slate-900/50 dark:text-slate-400">
                {{-- Hidden input untuk dikirim ke backend/kalkulasi --}}
                <input type="hidden" name="level" x-model="selectedLevel">
              </div>

              {{-- 2. Tingkat (Usia) - EDITABLE (Exception) --}}
              <div x-show="eventType === 'pertandingan'">
                <label for="competition_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Tingkat (Usia)
                </label>
                <select name="competition_level" id="competition_level" :required="eventType === 'pertandingan'"
                  x-model="selectedCompetitionLevel"
                  class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500">
                  <option value="" disabled>-- Pilih Tingkat Usia --</option>
                  @php $competitionLevels = ['Usia Dini 1', 'Usia Dini 2', 'Pra Remaja', 'Remaja', 'Dewasa']; @endphp
                  @foreach ($competitionLevels as $compLevel)
                    <option value="{{ $compLevel }}">{{ $compLevel }}</option>
                  @endforeach
                </select>
              </div>

              {{-- 3. Kategori - EDITABLE (Exception) --}}
              <div x-show="eventType === 'pertandingan'">
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Kategori
                </label>
                <select name="category" id="category" :required="eventType === 'pertandingan'"
                  x-model="selectedCategory" x-on:change="calculatePrice()"
                  class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500">
                  <option value="" disabled>-- Pilih Kategori --</option>
                  @php $categories = ['Tanding', 'TGR', 'Serang Hindar']; @endphp
                  @foreach ($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                  @endforeach
                </select>
              </div>

              {{-- 4. KELAS TANDING - EDITABLE (Exception) --}}
              <div x-show="selectedCategory === 'Tanding'" class="sm:col-span-full">
                <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                  Kelas Tanding
                </label>
                <select name="class" id="class" :required="selectedCategory === 'Tanding'"
                  class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-blue-600 focus:ring-blue-600 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:focus:border-blue-500">
                  <option value="" disabled selected>-- Pilih Kelas --</option>
                  <optgroup label="Putra">
                    @foreach (range('A', 'J') as $char)
                      <option value="Kelas {{ $char }} Putra">Kelas {{ $char }} Putra</option>
                    @endforeach
                    <option value="Bebas Putra">Kelas Bebas Putra</option>
                  </optgroup>
                  <optgroup label="Putri">
                    @foreach (range('A', 'J') as $char)
                      <option value="Kelas {{ $char }} Putri">Kelas {{ $char }} Putri</option>
                    @endforeach
                    <option value="Bebas Putri">Kelas Bebas Putri</option>
                  </optgroup>
                </select>
              </div>
            </div>

            {{-- Kuota Info --}}
            <div x-show="eventType !== 'ujian' && eventType !== 'pertandingan'">
              <p class="text-sm text-slate-600 dark:text-slate-400">Tiket standar untuk event ini.</p>
            </div>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Sisa kuota: {{ $event->ticket_quota }}</p>
          </div>
        </div>

        {{-- Bagian 3: Total & Submit --}}
        <div
          class="overflow-hidden rounded-xl bg-white shadow-lg ring-1 ring-slate-900/5 dark:bg-slate-800 dark:ring-white/10">
          <div class="p-5 sm:flex sm:items-center sm:justify-between">
            <div class="sm:pr-4">
              <p class="text-sm text-slate-600 dark:text-slate-400">Total Bayar:</p>
              <p class="text-2xl font-bold text-slate-900 dark:text-white" x-text="formatCurrency(calculatedPrice)">
              </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:shrink-0">
              <button type="submit"
                :disabled="calculatedPrice <= 0 || (eventType === 'ujian' && !selectedLevel) || (
                    eventType === 'pertandingan' && !selectedCategory)"
                class="flex w-full items-center justify-center rounded-lg bg-blue-600 px-6 py-3 text-base font-semibold text-white shadow-sm transition-colors duration-200 hover:bg-blue-700 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:cursor-not-allowed disabled:opacity-50">
                Lanjutkan ke Pembayaran
                <span class="ml-1.5 hidden sm:inline" x-text="'(' + formatCurrency(calculatedPrice) + ')'"></span>
              </button>
            </div>
          </div>
        </div>

      </form> {{-- Akhir Form --}}

    </div> {{-- Akhir div Alpine --}}
  </div> {{-- Akhir Kontainer Utama --}}
</x-app-layout>
