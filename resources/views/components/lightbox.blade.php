{{--
  Komponen ini akan:
  - Menerima daftar gambar (images)
  - Menggunakan Alpine.js untuk menampilkan modal saat gambar diklik
  - Menampilkan backdrop blur
--}}
@props(['images' => []])

<div x-data="{
    open: false,
    activeImage: '',
    images: {{ json_encode($images) }},
    activeIndex: 0,

    openLightbox(index) {
        this.activeIndex = index;
        this.activeImage = this.images[index];
        this.open = true;
    },

    closeLightbox() {
        this.open = false;
    },

    nextImage() {
        this.activeIndex = (this.activeIndex + 1) % this.images.length;
        this.activeImage = this.images[this.activeIndex];
    },

    prevImage() {
        this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length;
        this.activeImage = this.images[this.activeIndex];
    }
}">

  {{ $slot }}

  <div x-cloak x-show="open" @keydown.escape.window="closeLightbox"
    class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
      x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
      x-transition:leave-end="opacity-0" @click="closeLightbox" class="absolute inset-0 bg-black/70 backdrop-blur-sm">
    </div>

    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
      x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
      x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
      class="relative max-w-4xl max-h-[90vh] w-full">

      <img :src="activeImage" alt="Image preview" class="w-full h-full object-contain rounded-lg shadow-2xl">

      <button @click="closeLightbox"
        class="absolute -top-4 -right-4 sm:top-0 sm:-right-10 text-white bg-slate-800/50 rounded-full p-1 focus:outline-none hover:bg-slate-700/50 transition">
        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      <template x-if="images.length > 1">
        <div>
          <button @click="prevImage"
            class="absolute top-1/2 left-0 sm:-left-10 transform -translate-y-1/2 text-white bg-slate-800/50 rounded-full p-1 focus:outline-none hover:bg-slate-700/50 transition">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
          </button>
          <button @click="nextImage"
            class="absolute top-1/2 right-0 sm:-right-10 transform -translate-y-1/2 text-white bg-slate-800/50 rounded-full p-1 focus:outline-none hover:bg-slate-700/50 transition">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
          </button>
        </div>
      </template>
    </div>
  </div>
</div>
