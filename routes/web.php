<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\CertificateController;

/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses Guest & User Belum Terverifikasi)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

/*
|--------------------------------------------------------------------------
| Rute Autentikasi Bawaan Breeze
|--------------------------------------------------------------------------
*/
// Rute seperti login, register, forgot-password, dan halaman verifikasi email
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Rute yang Memerlukan Login & Verifikasi Email
|--------------------------------------------------------------------------
|
| Middleware 'auth' memastikan user harus login.
| Middleware 'verified' memastikan user harus sudah verifikasi email.
| Jika belum verifikasi, user akan otomatis diarahkan ke halaman 'verify-email'.
|
*/
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order (Form & Proses)
    Route::get('/events/{event}/checkout', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/events/{event}/checkout-process', [OrderController::class, 'store'])->name('orders.store');

    // Pembayaran
    Route::get('/my-checkout/{order}/pay', [PaymentController::class, 'show'])->name('orders.payment');

    // Tiket Saya
    Route::get('/my-receipts', [TicketController::class, 'index'])->name('my-tickets.index');
    Route::get('/my-receipts/{order}/show', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/my-receipts/{order}/get', [TicketController::class, 'download'])->name('tickets.download');
    Route::delete('/my-receipts/{order}/remove', [TicketController::class, 'cancel'])->name('tickets.cancel');

    // Sertifikat
    Route::get('/certificates/{order}/download', [CertificateController::class, 'download'])->name('certificates.download');
});

/*
|--------------------------------------------------------------------------
| Rute Webhook (Publik & Tanpa CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
