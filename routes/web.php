<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;

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
Route::middleware(['auth'])->group(function () {

    // Rute Dashboard (Breeze)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order (Form & Proses)
    Route::get('/events/{event}/order', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/events/{event}/order', [OrderController::class, 'store'])->name('orders.store');

    // Pembayaran
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('orders.payment');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Tiket Saya
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('my-tickets.index');
    Route::get('/tickets/{order}/view', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{order}/download', [TicketController::class, 'download'])->name('tickets.download');
    Route::delete('/tickets/{order}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
});
/*
|--------------------------------------------------------------------------
| Rute Webhook (Publik & Tanpa CSRF)
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');
