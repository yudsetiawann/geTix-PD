<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn; // Pastikan plugin terinstall
use Filament\Support\Enums\FontWeight;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Tampilkan Gambar (Membuat tabel visual)
                SpatieMediaLibraryImageColumn::make('thumbnail')
                    ->collection('thumbnails')
                    ->circular() // Atau square(), opsional
                    ->label('Img'),

                // 2. Stack Title dengan Meta info (Modern Look)
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn($record) => $record->location) // Lokasi jadi deskripsi kecil di bawah judul
                    ->wrap(),

                // 3. Tanggal dengan Icon
                TextColumn::make('starts_at')
                    ->dateTime('d M Y')
                    ->icon('heroicon-m-calendar')
                    ->sortable()
                    ->label('Tanggal'),

                // 4. Visualisasi Kuota dengan Warna
                TextColumn::make('ticket_sold')
                    ->label('Status Kuota')
                    ->formatStateUsing(fn($record) => "{$record->ticket_sold} / {$record->ticket_quota}")
                    ->badge()
                    ->color(
                        fn($record) =>
                        $record->ticket_sold >= $record->ticket_quota ? 'danger' : ($record->ticket_sold >= $record->ticket_quota * 0.8 ? 'warning' : 'success')
                    )
                    ->icon('heroicon-m-ticket'),

                // TextColumn::make('ticket_price')
                //     ->money('IDR')
                //     ->label('Harga Mulai')
                //     ->placeholder('Gratis / Dinamis')
                //     ->sortable(),
            ])
            ->filters([
                // Filter berdasarkan Tipe Event akan sangat berguna
                // SelectFilter::make('event_type')...
            ])
            ->recordActions([
                EditAction::make()->iconButton(), // Gunakan iconButton agar lebih minimalis
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
