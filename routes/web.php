<?php

use App\Models\Event;
use App\Livewire\PublicUnitList;
use App\Livewire\PublicCoachList;
use App\Livewire\Coach\AthleteList;
use App\Livewire\PublicAthleteList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\Coach\AthleteVerification;
use App\Http\Controllers\MidtransController;
use App\Livewire\PublicOrganizationStructure;
use App\Http\Controllers\CertificateController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

Route::get('/', WelcomeController::class)->name('home');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| GROUP 1: Login & Verifikasi Email (Tanpa Cek Status Member)
|--------------------------------------------------------------------------
| Rute ini HARUS bisa diakses oleh member yang statusnya 'pending' atau
| 'incomplete' agar mereka bisa memperbaiki data diri.
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil (PENTING: Jangan masukkan ke middleware verified_member)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| GROUP 2: Login, Email Verified, DAN Member Verified (Approved)
|--------------------------------------------------------------------------
| Semua fitur inti ada di sini. Jika user belum di-ACC pelatih,
| mereka akan ditendang ke Home oleh middleware 'verified_member'.
*/
Route::middleware(['auth', 'verified', 'verified_member'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Event
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

    // Menu Anggota & Ranting
    Route::get('/daftar-anggota', function () {
        return view('public.member-menu');
    })->name('public.menu');

    Route::get('/daftar-anggota/semua', PublicAthleteList::class)->name('public.athletes.all');
    Route::get('/daftar-anggota/ranting', PublicUnitList::class)->name('public.units');
    Route::get('/daftar-anggota/ranting/{unit}', PublicAthleteList::class)->name('public.athletes.by-unit');
    Route::get('/daftar-anggota/pelatih', PublicCoachList::class)->name('public.coaches');

    Route::get('/struktur-organisasi', PublicOrganizationStructure::class)->name('public.structure');

    // Transaksi & Tiket
    Route::get('/events/{event}/checkout', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/events/{event}/checkout-process', [OrderController::class, 'store'])->name('orders.store');

    Route::get('/my-checkout/{order}/pay', [PaymentController::class, 'show'])->name('orders.payment');
    Route::post('/my-checkout/{order}/pay-cash', [OrderController::class, 'payCash'])->name('orders.pay-cash');

    Route::get('/my-receipts', [TicketController::class, 'index'])->name('my-tickets.index');
    Route::get('/my-receipts/{order}/show', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/my-receipts/{order}/get', [TicketController::class, 'download'])->name('tickets.download');
    Route::delete('/my-receipts/{order}/remove', [TicketController::class, 'cancel'])->name('tickets.cancel');

    Route::get('/certificates/{order}/download', [CertificateController::class, 'download'])->name('certificates.download');

    // Menu Khusus Coach (Sudah dilindungi verified_member, jadi aman)
    Route::get('/coach/verification', AthleteVerification::class)->name('coach.verification');
    Route::get('/coach/athletes', AthleteList::class)->name('coach.athletes');

    // News
    Route::prefix('news')->name('news.')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('index');
        Route::get('/{post:slug}', [NewsController::class, 'show'])->name('show');
    });
});

/*
|--------------------------------------------------------------------------
| Webhook (Bypass CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
