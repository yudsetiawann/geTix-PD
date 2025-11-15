<x-app-layout title="Tiket Saya">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
      Riwayat Tiket Saya
    </h1>
  </x-slot>

  {{-- Kontainer Utama dengan padding --}}
  <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">

    {{-- Tampilkan pesan sukses jika ada (setelah batal order) --}}
    @if (session('success'))
      <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-800 dark:bg-green-900/50">
        <div class="flex">
          <div class="shrink-0">
            {{-- Ikon Check --}}
            <svg class="size-5 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ session('success') }}</p>
          </div>
        </div>
      </div>
    @endif

    {{-- Daftar Tiket --}}
    <div class="space-y-6">
      @forelse ($orders as $order)
        <div class="overflow-hidden rounded-xl bg-white shadow-md dark:bg-slate-800 sm:flex">

          {{-- Bagian Konten Kiri (Info Tiket) --}}
          <div class="grow p-5 sm:p-6">
            <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $order->event->title }}</h2>

            {{-- Meta Info --}}
            <div
              class="mt-2 flex flex-col gap-y-1 text-sm text-slate-600 dark:text-slate-400 sm:flex-row sm:flex-wrap sm:gap-x-4">
              <p class="flex items-center">
                <svg class="mr-1.5 size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A1.875 1.875 0 0 1 18 22.5H6A1.875 1.875 0 0 1 4.501 20.118Z" />
                </svg>
                {{ $order->customer_name }}
              </p>
              <p class="flex items-center">
                <svg class="mr-1.5 size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                  viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                Dipesan: {{ $order->created_at->format('d M Y') }}
              </p>
            </div>

            {{-- Total Harga --}}
            <p class="mt-4 text-lg font-bold text-slate-800 dark:text-slate-100">
              Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </p>
          </div>

          {{-- Bagian Aksi Kanan (Tombol) --}}
          <div
            class="flex shrink-0 flex-col gap-3 bg-slate-50 p-5 dark:bg-slate-800/50 sm:w-56 sm:items-stretch sm:justify-center sm:border-l sm:dark:border-slate-700">
            @if ($order->status === 'paid')
              @if ($order->ticket_code)
                <a href="{{ route('tickets.show', $order) }}" target="_blank"
                  class="w-full sm:w-auto text-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-blue-700">
                  Lihat E-Ticket
                </a>
                <a href="{{ route('tickets.download', $order) }}"
                  class="w-full sm:w-auto text-center rounded-lg bg-slate-100 px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition-colors duration-200 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-200 dark:hover:bg-slate-600">
                  Download
                </a>
              @else
                {{-- Jika status paid tapi kode tiket belum ada --}}
                <span
                  class="rounded-full bg-yellow-50 px-3 py-1.5 text-center text-sm font-medium text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-300">
                  Diproses
                </span>
              @endif
            @elseif ($order->status === 'pending')
              {{-- Tombol Bayar --}}
              <a href="{{ route('orders.payment', $order) }}"
                class="w-full sm:w-auto text-center rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-green-700">
                Bayar
              </a>
              {{-- Tombol Batalkan (form) --}}
              <form action="{{ route('tickets.cancel', $order) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="w-full text-center rounded-lg px-4 py-2 text-sm font-medium text-red-600 transition-colors duration-200 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/30">
                  Batalkan
                </button>
              </form>
            @else
              {{-- Status failed atau expired --}}
              <span @class([
                  'rounded-full px-3 py-1.5 text-center text-sm font-medium',
                  'bg-red-50 text-red-700 dark:bg-red-900/50 dark:text-red-300' =>
                      $order->status === 'failed',
                  'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' =>
                      $order->status !== 'failed',
              ])>
                {{ ucfirst($order->status) }}
              </span>
            @endif
          </div>
          {{-- Akhir Bagian Aksi --}}

        </div>
      @empty
        {{-- Tampilan jika tidak ada tiket --}}
        <div
          class="col-span-1 rounded-xl border border-dashed border-slate-300 dark:border-slate-700 p-12 text-center sm:col-span-2 lg:col-span-3">
          <svg class="mx-auto size-16 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
          </svg>
          <h3 class="mt-4 text-xl font-semibold text-slate-900 dark:text-white">Belum Ada Tiket</h3>
          <p class="mt-2 text-base text-slate-600 dark:text-slate-400">
            Anda belum memiliki riwayat pembelian tiket.
          </p>
          <div class="mt-6">
            <a href="{{ route('events.index') }}"
              class="inline-block rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors duration-200 hover:bg-blue-700">
              Cari Event Sekarang
            </a>
          </div>
        </div>
      @endforelse
    </div>

    {{-- Link Paginasi --}}
    <div class="mt-12">
      {{ $orders->links() }}
    </div>

  </div>

</x-app-layout>
