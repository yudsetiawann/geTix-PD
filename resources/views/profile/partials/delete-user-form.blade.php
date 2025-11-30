<section class="rounded-xl border border-red-100 bg-red-50/50 p-4 sm:p-8 dark:border-red-900/30 dark:bg-red-900/10">

  {{-- Header Section --}}
  <header class="flex flex-col sm:flex-row items-start gap-4 mb-6">
    <div
      class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
      {{-- Ikon Sampah --}}
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
      </svg>
    </div>
    <div>
      <h2 class="text-lg font-bold text-slate-900 dark:text-white">
        {{ __('Hapus Akun') }}
      </h2>
      <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
        {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Harap unduh data atau informasi apa pun yang ingin Anda simpan sebelum menghapus akun.') }}
      </p>
    </div>
  </header>

  <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    class="w-full sm:w-auto justify-center px-5 py-2.5 text-sm font-semibold">
    {{ __('Hapus Akun') }}
  </x-danger-button>

  {{-- Modal Konfirmasi --}}
  <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    {{-- Wrapper Konten Modal: Menggunakan p-4 untuk mobile agar lebih hemat tempat --}}
    <div class="p-4 sm:p-6 bg-white dark:bg-slate-800">
      <form method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')

        {{-- Header Modal --}}
        <div class="flex items-center gap-3 mb-4">
          <div
            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
            </svg>
          </div>
          <h2 class="text-lg font-bold text-slate-900 dark:text-white leading-tight">
            {{ __('Apakah Anda yakin?') }}
          </h2>
        </div>

        <p class="text-sm text-slate-600 dark:text-slate-400">
          {{ __('Akun akan dihapus permanen. Masukkan kata sandi Anda untuk konfirmasi.') }}
        </p>

        {{-- Input Password --}}
        <div class="mt-6">
          <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

          <x-text-input id="password" name="password" type="password"
            class="mt-1 block w-full rounded-lg border-slate-300 focus:border-red-500 focus:ring-red-500 dark:border-slate-700 dark:bg-slate-900 dark:text-white"
            placeholder="{{ __('Password') }}" />

          <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        {{-- Tombol Aksi: Stacked pada Mobile --}}
        <div class="mt-6 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
          <x-secondary-button x-on:click="$dispatch('close')"
            class="w-full sm:w-auto justify-center px-4 py-2 hover:bg-gray-200 rounded-lg cursor-pointer">
            {{ __('Batal') }}
          </x-secondary-button>

          <x-danger-button
            class="w-full sm:w-auto justify-center px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 border-transparent cursor-pointer">
            {{ __('Ya, Hapus Akun') }}
          </x-danger-button>
        </div>
      </form>
    </div>
  </x-modal>
</section>
