<x-app-layout title="Pembayaran Tiket">
  <x-slot name="header">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
      Selesaikan Pembayaran
    </h1>
  </x-slot>

  {{-- Kontainer Utama --}}
  <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="mx-auto max-w-lg">

      {{-- NOTIFIKASI (Pengganti Alert) --}}
      <div id="status-success" style="display: none;"
        class="mb-6 rounded-xl border border-green-200 bg-green-50 p-5 dark:border-green-800 dark:bg-green-900/50">
        <div class="flex">
          <div class="shrink-0">
            <svg class="size-6 text-green-600 dark:text-green-400" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-lg font-medium text-green-800 dark:text-green-300">Pembayaran Berhasil!</h3>
            <p class="mt-2 text-sm text-green-700 dark:text-green-400">
              Terima kasih. Anda akan diarahkan ke halaman 'Tiket Saya' dalam 3 detik.
            </p>
          </div>
        </div>
      </div>

      <div id="status-pending" style="display: none;"
        class="mb-6 rounded-xl border border-yellow-200 bg-yellow-50 p-5 dark:border-yellow-800 dark:bg-yellow-900/50">
        <div class="flex">
          <div class="shrink-0">
            <svg class="size-6 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-13a.75.75 0 0 0-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 0 0 0-1.5h-3.25V5Z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-lg font-medium text-yellow-800 dark:text-yellow-300">Menunggu Pembayaran</h3>
            <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-400">
              Silakan selesaikan pembayaran Anda.
            </p>
          </div>
        </div>
      </div>

      <div id="status-error" style="display: none;"
        class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5 dark:border-red-800 dark:bg-red-900/50">
        <div class="flex">
          <div class="shrink-0">
            <svg class="size-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
              fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm-1.75-4.5a.75.75 0 0 0 1.5 0v-2.5a.75.75 0 0 0-1.5 0v2.5ZM10 10a.75.75 0 0 0-1.5 0v.01a.75.75 0 0 0 1.5 0V10Z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <div class="ml-3">
            <h3 class="text-lg font-medium text-red-800 dark:text-red-300">Pembayaran Gagal</h3>
            <p class="mt-2 text-sm text-red-700 dark:text-red-400">
              Terjadi kesalahan. Silakan coba lagi atau hubungi admin.
            </p>
          </div>
        </div>
      </div>
      {{-- AKHIR NOTIFIKASI --}}


      {{-- KARTU PEMBAYARAN --}}
      <div id="payment-card"
        class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-md dark:border-slate-700 dark:bg-slate-800">

        {{-- Card Header --}}
        <div class="border-b border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800/50 sm:px-6">
          <h2 class="text-base font-semibold leading-6 text-slate-900 dark:text-white">Detail Tagihan</h2>
          <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Order ID: {{ $order->order_code }}</p>
        </div>

        {{-- Card Body --}}
        <div class="p-6 text-center sm:p-8">
          <p class="text-lg font-medium text-slate-700 dark:text-slate-300">{{ $order->event->title }}</p>

          <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Total Tagihan:</p>
          <p class="mt-1 text-4xl font-bold tracking-tight text-slate-900 dark:text-white">
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
          </p>

          {{-- OPSI PEMBAYARAN --}}
          <div class="mt-8 space-y-4">

            <button id="pay-button"
              class="flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-6 py-3 text-lg font-semibold text-white shadow-sm transition-colors duration-200 hover:bg-green-700 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-green-600">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
              </svg>
              Bayar Online / Transfer
            </button>

            <div class="relative">
              <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
              </div>
              <div class="relative flex justify-center">
                <span class="bg-white px-2 text-sm text-gray-500 dark:bg-slate-800 dark:text-gray-400">Atau</span>
              </div>
            </div>

            <form action="{{ route('orders.pay-cash', $order) }}" method="POST">
              @csrf
              <button type="submit"
                onclick="return confirm('Apakah Anda yakin ingin membayar secara tunai/kolektif? \n\nTagihan ini akan ditandai pending dan Anda harus membayar ke Koordinator Cabang.')"
                class="flex w-full items-center justify-center gap-2 rounded-lg border-2 border-slate-300 bg-transparent px-6 py-3 text-lg font-semibold text-slate-700 transition-colors duration-200 hover:bg-slate-50 hover:text-slate-900 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-slate-600 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700 dark:hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="size-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-1.952-1.952 9 9 0 0 0-3.741-.479m-2.25-3.393a6.765 6.765 0 0 0-2.579-.598A2.25 2.25 0 0 1 13.5 9.603V4.5a2.25 2.25 0 0 0-2.25-2.25H9a2.25 2.25 0 0 0-2.25 2.25v9.375c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25m3.75 9v4.5m0-4.5h2.25m-2.25 0h-2.25" />
                </svg>
                Bayar Tunai / Kolektif
              </button>
            </form>

          </div>
          {{-- END OPSI PEMBAYARAN --}}

          <div class="mt-6 flex items-center justify-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
            <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M10 1a4.5 4.5 0 0 0-4.5 4.5V9H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-.5V5.5A4.5 4.5 0 0 0 10 1Zm3 8V5.5a3 3 0 1 0-6 0V9h6Z"
                clip-rule="evenodd" />
            </svg>
            <span>Pembayaran online didukung oleh Midtrans. Pembayaran tunai diverifikasi manual.</span>
          </div>
        </div>
      </div>

    </div>
  </div>

  {{-- Script Midtrans Snap --}}
  <script src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('services.midtrans.client_key') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ambil elemen-elemen
      const payButton = document.getElementById('pay-button');
      const paymentCard = document.getElementById('payment-card');
      const successMsg = document.getElementById('status-success');
      const pendingMsg = document.getElementById('status-pending');
      const errorMsg = document.getElementById('status-error');

      // Sembunyikan semua pesan notifikasi
      successMsg.style.display = 'none';
      pendingMsg.style.display = 'none';
      errorMsg.style.display = 'none';

      payButton.addEventListener('click', function() {
        // Tampilkan loading di tombol (opsional)
        payButton.disabled = true;
        payButton.textContent = 'Memproses...';

        window.snap.pay('{{ $order->midtrans_token }}', {
          onSuccess: function(result) {
            paymentCard.style.display = 'none';
            successMsg.style.display = 'block';
            console.log('Success:', result);
            setTimeout(function() {
              window.location.href = '{{ route('my-tickets.index') }}';
            }, 3000);
          },
          onPending: function(result) {
            paymentCard.style.display = 'none';
            pendingMsg.style.display = 'block';
            console.log('Pending:', result);
            setTimeout(function() {
              window.location.href = '{{ route('my-tickets.index') }}';
            }, 3000);
          },
          onError: function(result) {
            paymentCard.style.display = 'none';
            errorMsg.style.display = 'block';
            console.log('Error:', result);
            // Re-enable button on error (optional)
            payButton.disabled = false;
            payButton.textContent = 'Bayar Online / Transfer';
          },
          onClose: function() {
            payButton.disabled = false;
            payButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                Bayar Online / Transfer`;
          }
        });
      });
    });
  </script>
</x-app-layout>
