<header x-data="{ mobileOpen: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 10)">

  {{-- CHECK VERIFICATION STATUS LOGIC --}}
  @php
    $user = Auth::user();
    $isUserVerified = false;

    if ($user) {
        if ($user->role === 'user') {
            // Logika Atlet: Harus approved
            $isUserVerified = $user->verification_status === 'approved';
        } elseif ($user->isCoach()) {
            // Logika Pelatih: Harus sudah pilih Unit Binaan
            $isUserVerified = $user->coachedUnits->isNotEmpty();
        } elseif ($user->isAdmin() || $user->isScanner()) {
            // Admin & Scanner selalu verified
            $isUserVerified = true;
        }
    }
  @endphp

  <nav class="fixed top-0 left-0 w-full z-50 transition-all duration-300"
    :class="{
        'bg-white/90 dark:bg-slate-900/90 shadow-lg backdrop-blur-lg': scrolled,
        'bg-white/70 dark:bg-slate-900/70 backdrop-blur-lg border-b border-white/20 dark:border-slate-800/30': !scrolled
    }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-18 items-center justify-between">
        {{-- Logo & Desktop Menu --}}
        <div class="flex items-center">
          <a href="/" class="flex items-center shrink-0 space-x-2.5 group">
            <img src="/img/Logo-PD.png" alt="PD-dig"
              class="h-10 w-auto transition-transform duration-300 group-hover:scale-110" />
            <span
              class="text-lg font-semibold text-slate-800 dark:text-slate-100 transition-colors group-hover:text-blue-600 dark:group-hover:text-blue-400">PD-dig</span>
          </a>

          {{-- Desktop Navigation Links --}}
          <div class="hidden md:ml-10 md:block">
            <div class="flex items-baseline space-x-4">
              <a href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }} rounded-lg px-3 py-2 text-sm transition-colors duration-200">Beranda</a>

              <a href="{{ route('events.index') }}"
                class="{{ request()->routeIs('events.index') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }} rounded-lg px-3 py-2 text-sm transition-colors duration-200">Events</a>

              <a href="{{ route('public.menu') }}"
                class="{{ request()->routeIs('public.menu') || request()->routeIs('public.athletes.all') || request()->routeIs('public.units') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }} rounded-lg px-3 py-2 text-sm transition-colors duration-200">Daftar
                Anggota</a>

              <a href="{{ route('public.structure') }}"
                class="{{ request()->routeIs('public.structure') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }} rounded-lg px-3 py-2 text-sm transition-colors duration-200">Struktur
                Organisasi</a>

              @auth
                <a href="{{ route('my-tickets.index') }}"
                  class="{{ request()->routeIs('my-tickets.index') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }} rounded-lg px-3 py-2 text-sm transition-colors duration-200">Tiket
                  Saya</a>
              @endauth

              @if (Auth::user()?->isCoach())
                <a href="{{ route('coach.verification') }}"
                  class="{{ request()->routeIs('coach.verification') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }} rounded-lg px-3 py-2 text-sm transition-colors duration-200">
                  Verifikasi Atlet
                </a>
                <a href="{{ route('coach.athletes') }}"
                  class="{{ request()->routeIs('coach.athletes') ? 'text-blue-600 dark:text-blue-400 font-medium' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }} rounded-lg px-3 py-2 text-sm transition-colors duration-200">
                  Data Atlet
                </a>
              @endif
            </div>
          </div>
        </div>

        {{-- Desktop Right Side (Dark Mode & User Menu) --}}
        <div class="hidden md:flex md:items-center md:space-x-2">
          {{-- Dark Mode Toggle --}}
          <button @click="darkMode = !darkMode" type="button"
            class="relative flex items-center rounded-full p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
            <span class="sr-only">Toggle dark mode</span>
            <svg x-cloak x-show="!darkMode" class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
            </svg>
            <svg x-cloak x-show="darkMode" class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
            </svg>
          </button>

          {{-- User Dropdown --}}
          @auth
            <div class="relative" x-data="{ open: false }">
              <button @click="open = !open"
                class="flex items-center space-x-2 rounded-full p-1 pr-3 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors duration-200">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white">
                  <span
                    class="text-sm font-medium leading-none">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </span>
                <span class="text-sm font-medium text-slate-700 dark:text-slate-200 flex items-center gap-1">
                  {{ Auth::user()->name }}
                  @if ($isUserVerified)
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                      class="size-4 text-blue-500" title="Terverifikasi">
                      <path fill-rule="evenodd"
                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                        clip-rule="evenodd" />
                    </svg>
                  @endif
                </span>
                <svg class="size-4 text-slate-500 dark:text-slate-400 transition-transform duration-200"
                  :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                  fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
                </svg>
              </button>

              {{-- Dropdown Menu --}}
              <div x-cloak x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl bg-white dark:bg-slate-800 py-1.5 shadow-lg ring-1 ring-black/5 dark:ring-white/10 focus:outline-none">

                {{-- Admin/Scanner Links --}}
                @if (Auth::user()->isAdmin())
                  <a href="{{ route('filament.admin.pages.dashboard') }}"
                    class="block px-4 py-2 text-sm font-semibold text-yellow-600 dark:text-yellow-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    Panel Admin
                  </a>
                @elseif (Auth::user()->isScanner())
                  <a href="{{ route('filament.admin.pages.scan-ticket') }}"
                    class="block px-4 py-2 text-sm font-semibold text-yellow-600 dark:text-yellow-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    Panel Scanner
                  </a>
                @endif

                @if (Auth::user()->isAdmin() || Auth::user()->isScanner())
                  <div class="my-1.5 h-px bg-slate-200 dark:bg-slate-700"></div>
                @endif

                {{-- User Links --}}
                <a href="{{ route('home') }}"
                  class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Beranda</a>
                <a href="{{ route('events.index') }}"
                  class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Events</a>

                <a href="{{ route('public.menu') }}"
                  class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Daftar
                  Anggota</a>

                <a href="{{ route('public.structure') }}"
                  class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Struktur
                  Organisasi</a>
                <a href="{{ route('my-tickets.index') }}"
                  class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Tiket
                  Saya</a>

                <div class="my-1.5 h-px bg-slate-200 dark:bg-slate-700"></div>

                <a href="{{ route('profile.edit') }}"
                  class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Profil
                  Saya</a>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit"
                    class="block w-full text-left px-4 py-2 text-sm text-red-500 dark:text-red-400 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">Keluar</button>
                </form>
              </div>
            </div>
          @else
            <a href="{{ route('login') }}"
              class="hidden lg:inline-block rounded-lg px-3 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white transition-colors duration-200">Masuk</a>
            <a href="{{ route('register') }}"
              class="inline-block rounded-lg bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 text-sm font-medium transition-all duration-200 shadow-sm hover:shadow-md">Daftar</a>
          @endauth
        </div>

        {{-- Mobile Menu Button --}}
        <div class="-mr-2 flex items-center md:hidden">
          <button @click="mobileOpen = !mobileOpen"
            class="relative inline-flex items-center justify-center rounded-md p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <span class="sr-only">Open main menu</span>
            <svg x-cloak x-show="!mobileOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <svg x-cloak x-show="mobileOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </nav>

  {{-- Mobile Menu Overlay --}}
  <div x-cloak x-show="mobileOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="mobileOpen = false"
    class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm md:hidden"></div>

  {{-- Mobile Menu Panel --}}
  <nav x-cloak x-show="mobileOpen" x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed top-0 right-0 w-full max-w-xs z-60 bg-white dark:bg-slate-900 shadow-xl md:hidden rounded-md h-full overflow-y-auto">

    <div class="flex items-center justify-between p-4 border-b dark:border-slate-700/50">
      <a href="/" class="flex items-center shrink-0 space-x-2.5">
        <img src="/img/Logo-PD.png" alt="PD-dig" class="h-9 w-auto" />
        <span class="text-base font-semibold text-slate-800 dark:text-slate-100">PD-dig</span>
      </a>
      <button @click="mobileOpen = false"
        class="relative inline-flex items-center justify-center rounded-md p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
        <span class="sr-only">Close menu</span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
          stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div class="p-4 space-y-4">
      <nav class="space-y-2">
        <a href="{{ route('home') }}"
          class="{{ request()->routeIs('home') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }} block rounded-lg px-3 py-2.5 text-base font-medium transition-colors">Beranda</a>
        <a href="{{ route('events.index') }}"
          class="{{ request()->routeIs('events.index') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }} block rounded-lg px-3 py-2.5 text-base font-medium transition-colors">Events</a>

        <a href="{{ route('public.menu') }}"
          class="{{ request()->routeIs('public.menu') || request()->routeIs('public.athletes.all') || request()->routeIs('public.units') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }} block rounded-lg px-3 py-2.5 text-base font-medium transition-colors">Daftar
          Anggota</a>

        {{-- NEW: Struktur Organisasi Added for Mobile --}}
        <a href="{{ route('public.structure') }}"
          class="{{ request()->routeIs('public.structure') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }} block rounded-lg px-3 py-2.5 text-base font-medium transition-colors">Struktur
          Organisasi</a>

        @auth
          <a href="{{ route('my-tickets.index') }}"
            class="{{ request()->routeIs('my-tickets.index') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }} block rounded-lg px-3 py-2.5 text-base font-medium transition-colors">Tiket
            Saya</a>

          @if (Auth::user()->isCoach())
            <a href="{{ route('coach.verification') }}"
              class="{{ request()->routeIs('coach.verification') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }} block rounded-lg px-3 py-2.5 text-base font-medium transition-colors">
              Verifikasi Atlet
            </a>
            <a href="{{ route('coach.athletes') }}"
              class="{{ request()->routeIs('coach.athletes') ? 'bg-blue-50 dark:bg-slate-800 text-blue-600 dark:text-blue-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }} block rounded-lg px-3 py-2.5 text-base font-medium transition-colors">
              Data Atlet
            </a>
          @endif
        @endauth
      </nav>

      <div class="my-1.5 h-px bg-slate-200 dark:bg-slate-700"></div>

      @auth
        <div class="flex items-center space-x-3">
          <div class="shrink-0">
            <span
              class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-white ring-1 ring-white/10">
              <span class="text-base font-medium leading-none">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </span>
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-base font-medium text-slate-800 dark:text-white truncate flex items-center gap-1">
              {{ Auth::user()->name }}
              @if ($isUserVerified)
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                  class="size-4 text-blue-500">
                  <path fill-rule="evenodd"
                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                    clip-rule="evenodd" />
                </svg>
              @endif
            </div>
            <div class="text-sm font-medium text-slate-500 dark:text-gray-400 truncate">
              {{ Auth::user()->email }}</div>
          </div>
        </div>

        <div class="space-y-2 mt-4">
          @if (Auth::user()->isAdmin())
            <a href="{{ route('filament.admin.pages.dashboard') }}"
              class="block w-full text-center rounded-lg px-3 py-2.5 text-base font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 hover:bg-yellow-100 dark:hover:bg-yellow-900/50 transition-colors">
              Panel Admin
            </a>
          @elseif (Auth::user()->isScanner())
            <a href="{{ route('filament.admin.pages.scan-ticket') }}"
              class="block w-full text-center rounded-lg px-3 py-2.5 text-base font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 hover:bg-yellow-100 dark:hover:bg-yellow-900/50 transition-colors">
              Panel Scanner
            </a>
          @endif

          <a href="{{ route('profile.edit') }}"
            class="block w-full text-center rounded-lg px-3 py-2.5 text-base font-medium text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Profil
            Saya</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
              class="block w-full text-center rounded-lg px-3 py-2.5 text-base font-medium text-red-500 dark:text-red-400 bg-red-50 dark:bg-red-900/30 hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">Keluar</button>
          </form>
        </div>
      @else
        <div class="space-y-2 mt-4">
          <a href="{{ route('login') }}"
            class="block w-full text-center rounded-lg bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 text-base font-medium transition-all duration-200 shadow-sm hover:shadow-md">Masuk</a>
          <a href="{{ route('register') }}"
            class="block w-full text-center rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-700 py-2.5 px-4 text-base font-medium transition-colors duration-200">Daftar</a>
        </div>
      @endauth

      <div class="my-1.5 h-px bg-slate-200 dark:bg-slate-700 mt-4"></div>

      <button @click="darkMode = !darkMode" type="button"
        class="w-full flex items-center justify-center space-x-2 rounded-lg py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
        <svg x-cloak x-show="!darkMode" class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>
        <svg x-cloak x-show="darkMode" class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>
        <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
      </button>
    </div>
  </nav>

</header>
