<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Support\Enums\FontWeight;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Unit / Ranting')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold) // Menebalkan huruf
                    ->icon('heroicon-m-building-office-2') // Memberi ikon gedung
                    ->color('gray')
                    ->description(fn($record) => $record->code ?? ''), // Opsional: tampilkan kode unit di bawah nama jika ada

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => ucwords(str_replace('_', ' ', $state))) // Mengubah "ranting_sekolah" jadi "Ranting Sekolah"
                    ->colors([
                        'success' => 'ranting',   // 'sekolah' akan berwarna Hijau
                        'warning' => 'unit',   // 'ranting' akan berwarna Kuning/Oranye
                        'info'    => 'cabang',    // 'cabang' akan berwarna Biru
                        'danger'  => 'instansi',    // 'khusus' akan berwarna Merah
                        'gray'    => 'umum',      // 'umum' akan berwarna Abu-abu
                    ]),

                TextColumn::make('athletes_count')
                    ->counts('athletes')
                    ->label('Total Atlet')
                    ->badge()
                    ->icon('heroicon-m-users')
                    ->color('gray')
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->recordActions([ // Menggunakan actions() lebih standar daripada recordActions()
                EditAction::make()->iconButton(),   // Tombol jadi ikon pensil
                DeleteAction::make()->iconButton(), // Tombol jadi ikon sampah
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->striped(); // Opsional: Memberi efek belang zebra agar baris lebih mudah dibaca
    }
}
