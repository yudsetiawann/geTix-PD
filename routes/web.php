<?php

use App\Livewire\PublicUnitList;
use App\Livewire\Coach\AthleteList;
use App\Livewire\PublicAthleteList;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Coach\AthleteVerification;
use App\Http\Controllers\MidtransController;
use App\Livewire\PublicOrganizationStructure;
use App\Http\Controllers\CertificateController;

/*
|--------------------------------------------------------------------------
| Rute Publik
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');
// 1. Halaman Menu Utama
Route::get('/daftar-anggota', function () {
    return view('public.member-menu');
})->name('public.menu');
// 2. Tampilkan SEMUA Atlet (Route lama dipindah kesini)
Route::get('/daftar-anggota/semua', PublicAthleteList::class)
    ->name('public.athletes.all');
// 3. Tampilkan Daftar Ranting
Route::get('/daftar-anggota/ranting', PublicUnitList::class)
    ->name('public.units');
// 4. Tampilkan Atlet per Ranting (Reuse component yang sama dengan filter)
Route::get('/daftar-anggota/ranting/{unit}', PublicAthleteList::class)
    ->name('public.athletes.by-unit');
Route::get('/struktur-organisasi', PublicOrganizationStructure::class)->name('public.structure');

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Rute Auth (Login Required)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order (Form & Proses)
    Route::get('/events/{event}/checkout', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/events/{event}/checkout-process', [OrderController::class, 'store'])->name('orders.store');

    // Pembayaran
    Route::get('/my-checkout/{order}/pay', [PaymentController::class, 'show'])->name('orders.payment');

    // [BARU] Route untuk Pembayaran Tunai
    Route::post('/my-checkout/{order}/pay-cash', [OrderController::class, 'payCash'])->name('orders.pay-cash');

    // Tiket Saya
    Route::get('/my-receipts', [TicketController::class, 'index'])->name('my-tickets.index');
    Route::get('/my-receipts/{order}/show', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/my-receipts/{order}/get', [TicketController::class, 'download'])->name('tickets.download');
    Route::delete('/my-receipts/{order}/remove', [TicketController::class, 'cancel'])->name('tickets.cancel');

    // Sertifikat
    Route::get('/certificates/{order}/download', [CertificateController::class, 'download'])->name('certificates.download');

    // Route Khusus Coach
    Route::get('/coach/verification', AthleteVerification::class)->name('coach.verification');
    Route::get('/coach/athletes', AthleteList::class)->name('coach.athletes');
});

/*
|--------------------------------------------------------------------------
| Webhook
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
