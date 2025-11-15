<?php

namespace App\Filament\Widgets;

use App\Models\Event;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;

class EventSalesTable extends BaseWidget
{
    protected static ?string $heading = 'Pendaftar (Lunas) per Event';
    protected int | string | array $columnSpan = 'full';
    protected static bool $isLazy = true; // Aktifkan Lazy Loading
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // Ambil event yang akan datang atau baru saja selesai
                Event::query()->where('ends_at', '>=', now()->subMonths(3))
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Nama Event')
                    ->searchable()
                    ->sortable()
                    ->limit(40), // Batasi panjang teks

                TextColumn::make('ticket_sold')
                    ->label('Terjual (Lunas)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('ticket_quota')
                    ->label('Sisa Kuota')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label('Tanggal Mulai')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('starts_at', 'asc');
    }
}
