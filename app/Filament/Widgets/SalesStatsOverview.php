<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Participant; // <-- Tambahkan ini
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class SalesStatsOverview extends BaseWidget
{
    // Aktifkan lazy loading agar tidak memperlambat dashboard
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        // Ambil data order lunas
        $paidOrders = Order::where('status', 'paid');

        // Hitung Total Pendapatan (dari order lunas)
        $totalRevenue = $paidOrders->sum('total_price');

        // Hitung Total Peserta/Tiket Terjual (dari order lunas)
        $totalTicketsSold = $paidOrders->sum('quantity');

        // BARU: Hitung Total Anggota di sistem (dari tabel Participant)
        $totalParticipants = Participant::count();

        // BARU: Hitung Total Pendaftar (semua status, termasuk pending)
        $totalRegistrants = Order::count();

        return [
            Stat::make('Total Pendapatan (Lunas)', Number::currency($totalRevenue, 'IDR'))
                ->description('Dari semua transaksi berhasil')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Peserta Lunas', $totalTicketsSold)
                ->description($totalRegistrants . ' Total Pendaftar (Termasuk Pending)')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('info'),

            Stat::make('Total Anggota (Atlet)', $totalParticipants)
                ->description('Total atlet terdaftar di sistem')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('warning'),
        ];
    }
}
