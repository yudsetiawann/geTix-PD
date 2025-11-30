@props(['name', 'show' => false, 'maxWidth' => '2xl'])

@php
  $maxWidth = [
      'sm' => 'sm:max-w-sm',
      'md' => 'sm:max-w-md',
      'lg' => 'sm:max-w-lg',
      'xl' => 'sm:max-w-xl',
      '2xl' => 'sm:max-w-2xl',
  ][$maxWidth];
@endphp

{{--
    SOLUSI: x-teleport="body"
    Ini memindahkan modal ke ujung tag <body> secara otomatis saat dirender,
    sehingga terlepas dari pengaruh CSS parent (seperti card profile).
--}}
<template x-teleport="body">
  <div x-data="{
      show: @js($show),
      focusables() {
          let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
          return [...$el.querySelectorAll(selector)]
              .filter(el => !el.hasAttribute('disabled'))
      },
      firstFocusable() { return this.focusables()[0] },
      lastFocusable() { return this.focusables().slice(-1)[0] },
      nextFocusable() { return this.focusables()[this.focusables().indexOf(document.activeElement) + 1] || this.firstFocusable() },
      prevFocusable() { return this.focusables()[this.focusables().indexOf(document.activeElement) - 1] || this.lastFocusable() },
  }" x-init="$watch('show', value => {
      if (value) {
          document.body.classList.add('overflow-y-hidden');
          {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
      } else {
          document.body.classList.remove('overflow-y-hidden');
      }
  })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null" x-on:close.window="show = false"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:keydown.escape.window="show = false" x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()" {{-- Styling untuk Wrapper Utama --}} x-show="show"
    class="fixed inset-0 z-999 overflow-y-auto px-4 py-6 sm:px-0" style="display: none;">
    {{-- BACKDROP (Layar Gelap) --}}
    <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
      x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
      <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
    </div>

    {{-- KONTEN MODAL --}}
    {{-- Kita tambah z-index relative disini untuk memastikan dia diatas backdrop --}}
    <div x-show="show"
      class="relative mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
      x-transition:enter="ease-out duration-300"
      x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
      x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
      {{ $slot }}
    </div>
  </div>
</template>
