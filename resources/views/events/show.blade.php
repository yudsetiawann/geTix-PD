<x-app-layout :title="$event->title">

  {{-- Gambar Utama --}}
  @if ($event->hasMedia('thumbnails'))
    <div class="mt-18 rounded h-64 w-full bg-slate-200 dark:bg-slate-800 sm:h-80 lg:h-96">
      <img src="{{ $event->getFirstMediaUrl('thumbnails') }}" alt="{{ $event->title }}"
        class="h-full w-full object-cover rounded-t-md">
    </div>
  @endif

  {{-- Konten Utama --}}
  <div class="bg-white dark:bg-slate-900 py-12 sm:py-16 rounded-md">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

      {{-- Tampilkan pesan error jika ada (misal tiket habis) --}}
      @if (session('error'))
        <div class="mb-8 rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/50">
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

      {{-- Layout Grid (Konten Kiri, Sidebar Kanan) --}}
      <div class="relative md:grid md:grid-cols-3 md:gap-12">

        {{-- Kolom Konten Utama (Kiri) --}}
        <div class="md:col-span-2 space-y-12">

          {{-- Judul dan Meta --}}
          <div>
            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
              {{ $event->title }}</h1>

            <div class="mt-4 flex flex-col flex-wrap gap-x-6 gap-y-2 text-slate-600 dark:text-slate-400 sm:flex-row">
              <div class="flex items-center gap-1.5">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span class="text-sm">{{ $event->starts_at->format('d M Y') }}
                  {{ $event->ends_at ? ' - ' . $event->ends_at->format('d M Y') : '' }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span class="text-sm">{{ $event->location }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
                </svg>
                <span class="text-sm">Sisa Kuota: {{ $event->ticket_quota }}</span>
              </div>
            </div>
          </div>

          {{-- Deskripsi --}}
          @if ($event->description)
            <div>
              <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Deskripsi Event</h2>
              <div
                class="prose prose-sm sm:prose-base mt-4 max-w-none text-slate-700 dark:text-slate-300 dark:prose-invert prose-a:text-blue-600 dark:prose-a:text-blue-400">
                {!! nl2br(e($event->description)) !!}
              </div>
            </div>
          @endif

          {{-- Peta Lokasi --}}
          @if ($event->location_map_link)
            <div>
              <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Peta Lokasi</h2>
              <div class="mt-4 aspect-video overflow-hidden rounded-xl border dark:border-slate-700">
                <iframe src="{{ $event->location_map_link }}" width="100%" height="450" style="border:0;"
                  allowfullscreen="" loading="lazy"></iframe>
              </div>
            </div>
          @endif

          {{-- Galeri --}}
          @if ($event->hasMedia('gallery'))
            <div>
              <h2 class="text-xl font-semibold text-slate-900 dark:text-white">Galeri</h2>

              {{-- Siapkan array URL gambar untuk Alpine.js --}}
              @php
                $galleryImages = $event->getMedia('gallery')->map(fn($media) => $media->getUrl())->toArray();
              @endphp

              {{-- Bungkus dengan komponen lightbox --}}
              <x-lightbox :images="$galleryImages">
                <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3">
                  @foreach ($galleryImages as $index => $imageUrl)
                    <div class="group relative overflow-hidden rounded-xl shadow-md">
                      {{-- Tambahkan @click --}}
                      <img @click="openLightbox({{ $index }})" src="{{ $imageUrl }}"
                        alt="Galeri Event {{ $index + 1 }}"
                        class="aspect-square w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer">
                    </div>
                  @endforeach
                </div>
              </x-lightbox>
            </div>
          @endif

        </div>

        {{-- Kolom Sidebar (Kanan) --}}
        <div class="mt-10 md:mt-0 md:col-span-1">
          <div class="sticky top-24 space-y-6"> {{-- top-24 = h-18 navbar + 1.5rem padding --}}

            {{-- Card Harga & Beli --}}
            <div class="rounded-xl bg-white dark:bg-slate-800 shadow-xl ring-1 ring-slate-900/5 dark:ring-white/10">
              <div class="p-5">
                {{-- Harga --}}
                @php
                  if ($event->has_dynamic_pricing && is_array($event->level_prices)) {
                      $prices = array_values($event->level_prices);
                      $min = min($prices);
                      $max = max($prices);
                  }
                @endphp
                <p class="text-sm text-slate-600 dark:text-slate-400">Harga Mulai:</p>
                <p class="text-3xl font-bold text-slate-900 dark:text-white">
                  @if ($event->has_dynamic_pricing && !empty($event->level_prices))
                    Rp. {{ number_format($min, 0, ',', '.') }}
                    @if ($min != $max)
                      <span class="text-xl font-normal text-slate-500"> – {{ number_format($max, 0, ',', '.') }}</span>
                    @endif
                  @else
                    Rp. {{ number_format($event->ticket_price, 0, ',', '.') }}
                  @endif
                </p>

                {{-- Tombol Aksi (CTA) --}}
                <div class="mt-6">
                  @php $isExpired = $event->starts_at->isPast(); @endphp

                  @if ($isExpired)
                    {{-- 1. Jika Event sudah lewat --}}
                    <span
                      class="w-full inline-block text-center rounded-lg bg-slate-400 px-4 py-2.5 text-md font-semibold text-white cursor-not-allowed dark:bg-slate-600">
                      Event Telah Berakhir
                    </span>
                  @elseif ($event->ticket_quota > 0)
                    {{-- 2. Jika Event masih ada DAN kuota masih ada --}}
                    <a href="{{ route('orders.create', $event) }}"
                      class="w-full inline-block text-center rounded-lg bg-green-600 px-4 py-2.5 text-md font-semibold text-white shadow-sm hover:bg-green-700 transition-all duration-200 hover:shadow-md focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-green-600">
                      Beli Tiket
                    </a>
                  @else
                    {{-- 3. Jika Event masih ada TAPI kuota habis --}}
                    <span
                      class="w-full inline-block text-center rounded-lg bg-red-500 px-4 py-2.5 text-md font-semibold text-white cursor-not-allowed dark:bg-red-700/80">
                      Tiket Habis
                    </span>
                  @endif
                </div>
              </div>
            </div>

            {{-- Card Narahubung --}}
            @if ($event->contact_person_name || $event->contact_person_phone)
              <div class="rounded-xl bg-slate-50 p-5 dark:bg-slate-800/80 ring-1 ring-slate-900/5 dark:ring-white/10">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Narahubung</h3>
                <div class="mt-3 space-y-1 text-sm">
                  @if ($event->contact_person_name)
                    <p class="flex items-center gap-2 text-slate-700 dark:text-slate-300">
                      <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.875 1.875 0 0 1 18 22.5H6A1.875 1.875 0 0 1 4.501 20.118Z" />
                      </svg>
                      {{ $event->contact_person_name }}
                    </p>
                  @endif
                  @if ($event->contact_person_phone)
                    <p class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                      <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.211-.998-.552-1.348l-5.116-4.404a1.125 1.125 0 0 0-1.569 0L8.03 14.732a11.25 11.25 0 0 1-6.797-6.797L4.625 6.53a1.125 1.125 0 0 0 0-1.569L.22 3.847a1.125 1.125 0 0 0-1.348-.552H.75A2.25 2.25 0 0 0-1.5 5.625v1.125Z" />
                      </svg>
                      {{ $event->contact_person_phone }}
                    </p>
                  @endif
                </div>
              </div>
            @endif

          </div>
        </div>
        {{-- Akhir Kolom Sidebar --}}

      </div>
      {{-- Akhir Layout Grid --}}
    </div>
  </div>
</x-app-layout>
