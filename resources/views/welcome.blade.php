<x-app-layout title="Selamat Datang">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
      Selamat Datang
    </h1>
  </x-slot>

  {{-- ========================================== --}}
  {{-- DATA DUMMY DOKUMENTASI & GALERI --}}
  {{-- ========================================== --}}
  @php
    // Data Dokumentasi Acara (Bisa diganti dengan data dari Database nanti)
    $documentationArchives = [
        [
            'title' => 'Perisai Diri Cup XX 2025',
            'date' => '25 Desember 2025',
            'description' =>
                'Dokumentasi perolehan medali dan pertandingan atlit Perisai Diri pada kejuaraan silat Perisai Diri Cup XX 2025 se-kabupaten Tasikmalaya antar pelajar.',
            'thumbnail' => asset('img/pdcup-xx.jpeg'),
            'links' => [
                'drive' => 'https://drive.google.com/',
                'instagram' => 'https://instagram.com/',
            ],
        ],
        [
            'title' => 'Ujian Kenaikan Tingkat (UKT) 2024',
            'date' => '12 Desember 2024',
            'description' =>
                'Kegiatan UKT Semester Ganjil yang diikuti oleh 250 peserta dari seluruh ranting di Kabupaten Tasikmalaya.',
            'thumbnail' => asset('img/6.jpg'), // Ganti dengan foto kegiatan
            'links' => [
                'drive' => 'https://drive.google.com/', // Link Google Drive
                'instagram' => 'https://instagram.com/', // Link Post Instagram
                'tiktok' => 'https://tiktok.com/', // Link Video TikTok
            ],
        ],
        [
            'title' => 'Latihan Gabungan Cabang',
            'date' => '15 Oktober 2024',
            'description' => 'Latihan bersama untuk mempererat silaturahmi dan penyamaan teknik antar unit latihan.',
            'thumbnail' => asset('img/3.jpg'),
            'links' => [
                'instagram' => 'https://instagram.com/',
                'tiktok' => 'https://tiktok.com/',
            ],
        ],
    ];

    // Data Galeri Bawah
    $welcomeImages = [
        asset('img/6.jpg'),
        asset('img/3.jpg'),
        asset('img/4.jpeg'),
        asset('img/2.jpg'),
        asset('img/7.jpg'),
        asset('img/8.jpg'),
        asset('img/5.jpg'),
        asset('img/1.jpg'),
    ];
  @endphp

  {{-- ========================================== --}}
  {{-- NOTIFIKASI LOGIC --}}
  {{-- ========================================== --}}
  @auth
    @php
      $user = Auth::user();
      $isCoach = $user->role === 'coach' || $user->hasRole('coach');
      $isAthlete = in_array($user->role, ['athlete', 'user']) || $user->hasRole('athlete');
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6 relative z-20">
      @if ($isCoach)
        @php $hasCoachedUnits = $user->coachedUnits->isNotEmpty(); @endphp
        @if (!$hasCoachedUnits)
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
                    class="text-sm font-medium text-yellow-800 hover:text-yellow-900 hover:underline">Lengkapi Profil
                    Sekarang →</a>
                </div>
              </div>
            </div>
          </div>
        @endif
      @elseif ($isAthlete)
        @if (is_null($user->unit_id))
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
                    class="text-sm font-medium text-yellow-800 hover:text-yellow-900 hover:underline">Lengkapi Profil
                    →</a></div>
              </div>
            </div>
          </div>
        @elseif ($user->verification_status === 'rejected')
          <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-md animate-pulse">
            <div class="flex">
              <div class="shrink-0"><svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd" />
                </svg></div>
              <div class="ml-3 w-full">
                <h3 class="text-sm font-medium text-red-800">Verifikasi Ditolak</h3>
                <div class="mt-2 text-sm text-red-700">
                  <p>Pengajuan verifikasi ditolak. Alasan: "{{ $user->rejection_note }}"</p>
                </div>
                <div class="mt-4"><a href="{{ route('profile.edit') }}"
                    class="text-sm font-medium text-red-800 hover:text-red-900 hover:underline">Perbaiki Data →</a></div>
              </div>
            </div>
          </div>
        @elseif ($user->verification_status === 'pending')
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
                  <p>Data Anda sedang ditinjau oleh pelatih unit <strong>{{ $user->unit->name ?? '' }}</strong>.</p>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif
    </div>
  @endauth


  {{-- HERO SECTION --}}
  <section class="relative min-h-[70vh] md:min-h-[80vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
      <img src="{{ asset('img/hero-BG.jpeg') }}" alt="Atlit Pencak Silat" loading="lazy"
        class="w-full h-full object-cover object-center" />
      <div class="absolute inset-0 bg-linear-to-t from-slate-950/60 via-slate-950/50 to-black/20"></div>
    </div>

    <div class="relative z-10 container mx-auto mt-38 md:mt-28 px-4 sm:px-6 lg:px-8 py-32 md:py-48 text-center">
      <h1
        class="text-4xl md:text-6xl font-extrabold text-white tracking-tight shadow-black/50 [text-shadow:0_2px_8px_var(--tw-shadow-color)]">
        Perisai Diri Kabupaten Tasikmalaya
      </h1>
      <p
        class="mt-6 text-lg md:text-xl text-slate-200 max-w-3xl mx-auto shadow-black/50 [text-shadow:0_1px_4px_var(--tw-shadow-color)]">
        Wadah resmi pembinaan prestasi, karakter, dan kekeluargaan Keluarga Silat Nasional Indonesia Perisai Diri Cabang
        Kabupaten Tasikmalaya.
      </p>

      <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
        <a href="{{ route('public.units') }}"
          class="w-full sm:w-auto inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:shadow-blue-500/40 transform hover:scale-105 transition-all duration-300">
          Lihat Semua Ranting
        </a>
        <a href="{{ route('public.structure') }}"
          class="w-full sm:w-auto inline-block bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white text-white font-bold py-3 px-8 rounded-lg text-lg shadow-lg hover:shadow-white/20 transform hover:scale-105 transition-all duration-300">
          Daftar Pelatih
        </a>
      </div>
    </div>
  </section>


  {{-- SECTION SEJARAH --}}
  <section class="py-16 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-center gap-12">
        <div class="w-full md:w-1/2">
          <div class="relative rounded-2xl overflow-hidden shadow-2xl">
            <img src="{{ asset('img/Pakdirdjoatmodjo.jpg') }}" alt="Sejarah Perisai Diri"
              class="w-full h-auto object-cover" onerror="this.src='https://placehold.co/600x400?text=Foto+Sejarah'">
            <div class="absolute inset-0 bg-blue-900/10"></div>
          </div>
        </div>
        <div class="w-full md:w-1/2">
          <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white mb-6">
            Sejarah Perisai Diri
          </h2>
          <div class="prose dark:prose-invert text-slate-600 dark:text-slate-300">
            <p class="mb-4">
              Keluarga Silat Nasional Indonesia Perisai Diri didirikan oleh <strong>R.M. Soebandiman
                Dirdjoatmodjo</strong> pada tanggal 2 Juli 1955 di Surabaya. Beliau adalah putra bangsawan Paku Alam
              yang mendedikasikan hidupnya untuk menggali dan melestarikan ilmu beladiri asli Indonesia.
            </p>
            <p class="mb-4">
              Teknik silat Perisai Diri mengandung unsur 156 aliran silat dari berbagai daerah di Indonesia ditambah
              dengan aliran Shaolin dari negeri Tiongkok. Teknik ini diramu menjadi teknik yang efektif, cepat, dan
              tepat dengan motto <em>"Pandai Silat Tanpa Cedera"</em>.
            </p>
            <p>
              Di Kabupaten Tasikmalaya, Perisai Diri terus berkembang mencetak atlet berprestasi dan membentuk karakter
              pemuda yang berbudi pekerti luhur serta memiliki kepercayaan diri yang kuat.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>


  {{-- SECTION EVENT TERAKHIR --}}
  @if (isset($latestEvents) && $latestEvents->count() > 0)
    <section class="py-16 bg-slate-50 dark:bg-slate-950">
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
          <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Event Terbaru</h2>
          <a href="{{ route('events.index') }}"
            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-medium text-sm flex items-center gap-1">
            Lihat Semua <span aria-hidden="true">→</span>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach ($latestEvents as $event)
            <a href="{{ route('events.show', $event) }}"
              class="group block bg-white dark:bg-slate-800 rounded-xl shadow-sm hover:shadow-md transition-all overflow-hidden border border-slate-200 dark:border-slate-700">
              <div class="h-40 w-full overflow-hidden relative">
                @if ($event->hasMedia('thumbnails'))
                  <img src="{{ $event->getFirstMediaUrl('thumbnails') }}"
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    alt="{{ $event->title }}">
                @else
                  <div class="w-full h-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                    <svg class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.008v.008H14v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zm0-6h.008v.008H12V11zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                    </svg>
                  </div>
                @endif
                <div
                  class="absolute top-2 right-2 bg-white/90 dark:bg-slate-900/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-slate-800 dark:text-white shadow-sm">
                  {{ $event->starts_at->format('d M') }}
                </div>
              </div>
              <div class="p-4">
                <h3
                  class="text-base font-bold text-slate-900 dark:text-white mb-1 line-clamp-1 group-hover:text-blue-600 transition-colors">
                  {{ $event->title }}
                </h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center gap-1">
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  {{ Str::limit($event->location, 30) }}
                </p>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif


  {{-- ========================================== --}}
  {{-- [BARU] SECTION DOKUMENTASI & ARSIP KEGIATAN --}}
  {{-- ========================================== --}}
  <section class="py-16 bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      {{-- Section Header --}}
      <div class="max-w-3xl mx-auto text-center mb-12">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
          Dokumentasi & Arsip Kegiatan
        </h2>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
          Rekam jejak aktivitas, latihan, dan prestasi Perisai Diri Kabupaten Tasikmalaya.
        </p>
      </div>

      {{-- Grid Layout --}}
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($documentationArchives as $doc)
          <div
            class="group flex flex-col bg-white dark:bg-slate-800 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-slate-200 dark:border-slate-700 overflow-hidden">

            {{-- Thumbnail Image --}}
            <div class="relative h-56 overflow-hidden">
              <img src="{{ $doc['thumbnail'] }}" alt="{{ $doc['title'] }}"
                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
              <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent opacity-60"></div>
              <div class="absolute bottom-3 left-4">
                <span class="inline-block px-2 py-1 bg-blue-600/90 text-white text-xs font-semibold rounded-md">
                  {{ $doc['date'] }}
                </span>
              </div>
            </div>

            {{-- Content --}}
            <div class="p-6 flex-1 flex flex-col">
              <h3
                class="text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">
                {{ $doc['title'] }}
              </h3>
              <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 flex-1">
                {{ $doc['description'] }}
              </p>

              {{-- External Links Buttons --}}
              <div class="flex flex-wrap gap-2 mt-auto pt-4 border-t border-slate-100 dark:border-slate-700">

                {{-- Link Google Drive (Foto) --}}
                @if (isset($doc['links']['drive']))
                  <a href="{{ $doc['links']['drive'] }}" target="_blank"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-700 hover:bg-green-100 rounded-full text-xs font-semibold transition-colors dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50"
                    title="Lihat Foto Lengkap">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                      <path
                        d="M12.01 1.485c-1.08 0-2.09.56-2.62 1.48L3.58 13.605l5.24 9.095h10.49c1.08 0 2.09-.56 2.62-1.48l5.81-10.64-5.24-9.095h-10.49zM11.63 3.485h9.61l-4.8 8.33-9.61-8.33 4.8-8.33zM4.64 14.165l4.35 7.54H18.6l-4.35-7.54-9.61 0zM19.46 12.835l-4.35 7.54 4.8 0 4.35-7.54-4.8 0z" />
                      {{-- Simple Triangle Representation --}}
                      <path d="M8.33 11.66L2.5 2h10l-5.83 9.66z" fill="#00AC47" />
                      <path d="M16.67 11.66H5l5.83 10.34h11.67l-5.83-10.34z" fill="#2684FC" />
                      <path d="M12.5 2L18.33 11.66L22.5 4.33L16.67 2H12.5z" fill="#FFBA00" />
                    </svg>
                    <span>Drive</span>
                  </a>
                @endif

                {{-- Link Instagram --}}
                @if (isset($doc['links']['instagram']))
                  <a href="{{ $doc['links']['instagram'] }}" target="_blank"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-pink-50 text-pink-700 hover:bg-pink-100 rounded-full text-xs font-semibold transition-colors dark:bg-pink-900/30 dark:text-pink-400 dark:hover:bg-pink-900/50"
                    title="Lihat di Instagram">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path
                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.069-4.85.069-3.204 0-3.584-.011-4.849-.069-3.225-.149-4.771-1.664-4.919-4.919-.058-1.265-.071-1.644-.071-4.849 0-3.204.013-3.583.071-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                    </svg>
                    <span>Instagram</span>
                  </a>
                @endif

                {{-- Link TikTok --}}
                @if (isset($doc['links']['tiktok']))
                  <a href="{{ $doc['links']['tiktok'] }}" target="_blank"
                    class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-full text-xs font-semibold transition-colors dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600"
                    title="Lihat di TikTok">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                      <path
                        d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z" />
                    </svg>
                    <span>TikTok</span>
                  </a>
                @endif

              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>


  {{-- SECTION LOKASI CABANG (GOOGLE MAPS) --}}
  <section class="py-16 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-10">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
          Lokasi Sekretariat
        </h2>
        <p class="mt-2 text-slate-600 dark:text-slate-400">Kunjungi sekretariat cabang kami untuk informasi lebih
          lanjut.</p>
      </div>

      <div
        class="rounded-2xl overflow-hidden shadow-lg border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 h-[450px]">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.8991799473365!2d108.10032947451782!3d-7.365197072476622!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f55ac5efa0557%3A0x2161a7fb50633c91!2sKantor%20Desa%20Mangunreja!5e0!3m2!1sen!2sid!4v1767338288124!5m2!1sen!2sid"
          class="w-full h-full border-0" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
    </div>
  </section>


  {{-- GALERI --}}
  <section class="py-16 sm:py-24 bg-white dark:bg-slate-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <div class="max-w-3xl mx-auto text-center mb-16">
        <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
          Galeri Kegiatan
        </h2>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">
          Momen dan semangat para atlit Perisai Diri dalam berbagai kegiatan.
        </p>
      </div>

      {{-- Bungkus dengan komponen lightbox --}}
      <x-lightbox :images="$welcomeImages">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              {{-- Tambahkan @click di sini --}}
              <img @click="openLightbox(0)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/6.jpg') }}" alt="Galeri Silat 1">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(1)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/3.jpg') }}" alt="Galeri Silat 2">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(2)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/4.jpeg') }}" alt="Galeri Silat 3">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(3)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/2.jpg') }}" alt="Galeri Silat 4">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(4)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/7.jpg') }}" alt="Galeri Silat 5">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(5)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/8.jpg') }}" alt="Galeri Silat 6">
            </div>
          </div>
          <div class="grid gap-4">
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(6)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/5.jpg') }}" alt="Galeri Silat 7">
            </div>
            <div class="group relative overflow-hidden rounded-xl shadow-lg">
              <img @click="openLightbox(7)"
                class="h-auto w-full object-cover transition-transform duration-300 group-hover:scale-105 cursor-pointer"
                src="{{ asset('img/1.jpg') }}" alt="Galeri Silat 8">
            </div>
          </div>
        </div>
      </x-lightbox>
    </div>
  </section>

</x-app-layout>
