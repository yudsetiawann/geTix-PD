<x-guest-layout>
  <form method="POST" action="{{ route('password.store') }}">
    @csrf

    <!-- Password Reset Token -->
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <!-- Email Address -->
    <div>
      <x-input-label for="email" class="dark:text-gray-200" :value="__('Email')" />
      <x-text-input id="email" class="block mt-1 w-full dark:text-gray-800" type="email" name="email"
        :value="old('email', $request->email)" required autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4" x-data="{ show: false }">
      <x-input-label for="password" class="dark:text-gray-200" :value="__('Password')" />

      <div class="relative">
        <x-text-input id="password" class="block mt-1 w-full dark:text-gray-800"
          x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" />

        <button type="button" @click="show = !show"
          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 dark:text-gray-500">
          <span class="sr-only">Show/hide password</span>

          <!-- Icon Mata (tersembunyi) -->
          <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5
                   c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639
                   C20.577 16.49 16.64 19.5 12 19.5
                   c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>

          <!-- Icon Mata Tercoret (tampil) -->
          <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12
                   C3.226 16.338 7.244 19.5 12 19.5
                   c.993 0 1.953-.138 2.863-.395M6.228 6.228
                   A10.451 10.451 0 0 1 12 4.5
                   c4.756 0 8.773 3.162 10.065 7.498
                   a10.522 10.522 0 0 1-4.293 5.774
                   M6.228 6.228 3 3m3.228 3.228 3.65 3.65
                   m7.894 7.894L21 21m-3.228-3.228-3.65-3.65
                   m0 0a3 3 0 1 0-4.243-4.243
                   m4.243 4.243-4.243-4.243" />
          </svg>
        </button>
      </div>

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4" x-data="{ show: false }">
      <x-input-label for="password_confirmation" class="dark:text-gray-200" :value="__('Confirm Password')" />
      <div class="relative">
        <x-text-input id="password_confirmation" class="block mt-1 w-full dark:text-gray-800"
          x-bind:type="show ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" />

        <button type="button" @click="show = !show"
          class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 dark:text-gray-500">
          <span class="sr-only">Show/hide password</span>

          <!-- Icon Mata (tersembunyi) -->
          <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5
                   c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639
                   C20.577 16.49 16.64 19.5 12 19.5
                   c-4.638 0-8.573-3.007-9.963-7.178Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>

          <!-- Icon Mata Tercoret (tampil) -->
          <svg x-show="show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12
                   C3.226 16.338 7.244 19.5 12 19.5
                   c.993 0 1.953-.138 2.863-.395M6.228 6.228
                   A10.451 10.451 0 0 1 12 4.5
                   c4.756 0 8.773 3.162 10.065 7.498
                   a10.522 10.522 0 0 1-4.293 5.774
                   M6.228 6.228 3 3m3.228 3.228 3.65 3.65
                   m7.894 7.894L21 21m-3.228-3.228-3.65-3.65
                   m0 0a3 3 0 1 0-4.243-4.243
                   m4.243 4.243-4.243-4.243" />
          </svg>
        </button>
      </div>
      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <x-primary-button>
        {{ __('Reset Password') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>
