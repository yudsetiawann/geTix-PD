<x-app-layout title="Pesan Tiket: {{ $event->title }}">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
      Form Pemesanan: {{ $event->title }}
    </h1>
  </x-slot>

  <div x-data="{
      // Data dari Controller
      eventType: '{{ $eventType }}',
      basePrice: {{ $event->ticket_price ?? 0 }},
      levelPrices: {{ json_encode($levelPrices) ?? '{}' }},
      hasDynamicPricing: {{ $hasDynamicPricing ? 'true' : 'false' }},
  
      // Input state
      selectedLevel: '{{ old('level', '') }}', // Untuk Ujian
      selectedCompetitionLevel: '{{ old('competition_level', '') }}', // Untuk Pertandingan (Usia Dini, dll)
      selectedCategory: '{{ old('category', '') }}', // Untuk Pertandingan (Tanding, TGR)
      quantity: 1, // Tetap 1
  
      // Hasil Kalkulasi
      calculatedPrice: 0,
  
      // Hitung harga berdasarkan tipe event dan input yang relevan
      calculatePrice() {
          if (!this.hasDynamicPricing) {
              this.calculatedPrice = this.basePrice;
              return;
          }
  
          let price = 0;
          if (this.eventType === 'ujian' && this.selectedLevel) {
              // Logika harga ujian (sabuk)
              if (['Pemula', 'Dasar I', 'Dasar II'].includes(this.selectedLevel)) price = this.levelPrices?.pemula_dasar2 ?? 0;
              else if (['Cakel', 'Putih'].includes(this.selectedLevel)) price = this.levelPrices?.cakel_putih ?? 0;
              else if (['Putih Hijau', 'Hijau'].includes(this.selectedLevel)) price = this.levelPrices?.putihhijau_hijau ?? 0;
          } else if (this.eventType === 'pertandingan' && this.selectedCategory) {
              // Logika harga pertandingan (kategori)
              const categoryKey = this.selectedCategory.toLowerCase().replace(' ', '_'); // 'Serang Hindar' -> 'serang_hindar'
              price = this.levelPrices?.[categoryKey] ?? 0;
          }
          this.calculatedPrice = price;
      },
      formatCurrency(amount) {
          return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(amount);
      }
  }" x-init="calculatePrice()">

    <div class="mx-auto max-w-2xl">
      {{-- Tampilkan error --}}
      @if (session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4 dark:bg-red-900/30">
          <p class="text-sm font-medium text-red-700 dark:text-red-300">{{ session('error') }}</p>
        </div>
      @endif
      @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 dark:bg-red-900/30">
          <h3 class="text-sm font-medium text-red-800 dark:text-red-200">Terjadi Kesalahan:</h3>
          <ul class="mt-2 list-disc pl-5 text-sm text-red-700 dark:text-red-300">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- <form action="{{ route('orders.store', $event) }}" method="POST" --}}
      <form action="{{ route('orders.store') }}" method="POST"
        class="space-y-6 rounded-lg bg-white p-6 shadow-sm dark:bg-gray-800">
        @csrf
        {{-- Kirim ID event lewat input hidden, bukan lewat URL --}}
        <input type="hidden" name="event_id" value="{{ $event->id }}">

        {{-- Ringkasan Event --}}
        <div class="border-b pb-4 dark:border-gray-700">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $event->title }}</h2>
          <p class="text-sm text-gray-600 dark:text-gray-400">{{ $event->location }} |
            {{ $event->starts_at->format('d M Y') }}</p>
        </div>

        {{-- Input Data Diri --}}
        <div>
          <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
            Lengkap</label>
          <input type="text" name="customer_name" id="customer_name" required value="{{ old('phone_number') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
        </div>
        <div>
          <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
            Telepon</label>
          <input type="tel" name="phone_number" id="phone_number" required value="{{ old('phone_number') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
        </div>
        <div>
          <label for="school" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ranting /
            Sekolah</label>
          <input type="text" name="school" id="school" required value="{{ old('school') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
        </div>

        {{-- === KONDISIONAL DROPDOWN === --}}
        <div>
          <label for="level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkatan</label>
          <select name="level" id="level" required x-model="selectedLevel" x-on:change="calculatePrice()"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
            <option value="" disabled>-- Pilih Tingkatan --</option>
            @php $levels = ['Pemula', 'Dasar I', 'Dasar II', 'Cakel', 'Putih', 'Putih Hijau', 'Hijau']; @endphp
            @foreach ($levels as $levelOption)
              <option value="{{ $levelOption }}">{{ $levelOption }}</option>
            @endforeach
          </select>
        </div>


        {{-- Dropdown Tingkatan USIA & KATEGORI (hanya untuk event 'pertandingan') --}}
        <div x-show="eventType === 'pertandingan'" class="space-y-6">
          <div>
            <label for="competition_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat
              (Usia)</label>
            <select name="competition_level" id="competition_level" :required="eventType === 'pertandingan'"
              {{-- Wajib jika pertandingan --}} x-model="selectedCompetitionLevel"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
              <option value="" disabled>-- Pilih Tingkat Usia --</option>
              @php $competitionLevels = ['Usia Dini 1', 'Usia Dini 2', 'Pra Remaja', 'Remaja', 'Dewasa']; @endphp
              @foreach ($competitionLevels as $compLevel)
                <option value="{{ $compLevel }}">{{ $compLevel }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori
              Pertandingan</label>
            <select name="category" id="category" :required="eventType === 'pertandingan'" {{-- Wajib jika pertandingan --}}
              x-model="selectedCategory" x-on:change="calculatePrice()"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500 dark:focus:ring-blue-500">
              <option value="" disabled>-- Pilih Kategori --</option>
              @php $categories = ['Tanding', 'TGR', 'Serang Hindar']; @endphp
              @foreach ($categories as $cat)
                <option value="{{ $cat }}">{{ $cat }}</option>
              @endforeach
            </select>
          </div>
        </div>
        {{-- === AKHIR KONDISIONAL DROPDOWN === --}}

        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Sisa kuota: {{ $event->ticket_quota }}</p>

        {{-- Total harga akhir --}}
        <div class="border-t pt-4 dark:border-gray-700">
          <p class="text-right text-xl font-bold text-gray-900 dark:text-white">
            Total Bayar: <span x-text="formatCurrency(calculatedPrice)"></span>
          </p>
        </div>

        {{-- Tombol Submit --}}
        <div class="pt-4">
          {{-- Disable jika harga 0 ATAU (jika ujian, level belum dipilih) ATAU (jika tanding, kategori belum dipilih) --}}
          <button type="submit"
            :disabled="calculatedPrice <= 0 || (eventType === 'ujian' && !selectedLevel) || (eventType === 'pertandingan' && !
                selectedCategory)"
            class="w-full rounded-md bg-blue-600 px-4 py-2 text-base font-semibold text-white shadow-sm hover:bg-blue-700 focus-visible:outline ... disabled:opacity-50 disabled:cursor-not-allowed">
            Lanjutkan ke Pembayaran (<span x-text="formatCurrency(calculatedPrice)"></span>)
          </button>
        </div>
      </form>
    </div>
  </div>
</x-app-layout>
