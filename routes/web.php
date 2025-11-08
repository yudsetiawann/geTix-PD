<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;

// Halaman Utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Verify
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Event
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

// Rute yang Memerlukan Login
Route::middleware('auth')->group(function () {
    // Profil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Order (Form & Proses)
    Route::get('/events/{event}/order', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/events/{event}/order', [OrderController::class, 'store'])->name('orders.store');

    // Pembayaran
    Route::get('/orders/{order}/payment', [PaymentController::class, 'show'])->name('orders.payment');

    // Tiket Saya
    Route::get('/my-tickets', [TicketController::class, 'index'])->name('my-tickets.index');
    Route::get('/tickets/{order}/view', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/{order}/download', [TicketController::class, 'download'])->name('tickets.download');
    Route::delete('/tickets/{order}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');
});

// Webhook Midtrans (Jangan di dalam middleware 'auth')
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])->name('midtrans.notification');

// Rute Autentikasi Breeze
require __DIR__ . '/auth.php';
