<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Tables\Table;
use Filament\Tables\Actions;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn(Builder $query) => $query->with(['coachedUnits']))
            ->columns([
                // Nama User
                TextColumn::make('name')
                    ->label('Nama Pengguna')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->description(fn($record) => $record->role === 'coach' ? 'Pelatih' : ($record->nik ?? '-'))
                    ->icon('heroicon-m-user-circle'),

                // Role Badge
                TextColumn::make('role')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => ucfirst($state))
                    ->colors([
                        'danger' => 'admin',
                        'success' => 'coach', // Coach warna hijau biar beda
                        'warning' => 'scanner',
                        'info' => 'user',
                    ])
                    ->icons([
                        'heroicon-m-shield-check' => 'admin',
                        'heroicon-m-academic-cap' => 'coach',
                        'heroicon-m-qr-code' => 'scanner',
                        'heroicon-m-user' => 'user',
                    ])
                    ->sortable(),

                // Tingkatan / Level
                TextColumn::make('level.name')
                    ->label('Tingkatan')
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->placeholder('-'),

                // Unit (Tampilkan Unit Latihan utk user, atau "Multi Unit" utk coach)
                TextColumn::make('unit.name')
                    ->label('Unit / Ranting')
                    ->sortable()
                    ->searchable()
                    ->placeholder(fn($record) => $record->role === 'coach' ? $record->coachedUnits->count() . ' Unit Binaan' : '-'),

                // Status Verifikasi
                TextColumn::make('verification_status')
                    ->label('Verifikasi')
                    ->badge()
                    ->colors([
                        'gray' => 'incomplete',
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),

                // No HP (Bisa di-toggle)
                TextColumn::make('phone_number')
                    ->label('WhatsApp')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter Role
                SelectFilter::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'coach' => 'Coach',
                        'scanner' => 'Scanner',
                        'user' => 'Atlet',
                    ]),

                // Filter Unit
                SelectFilter::make('unit_id')
                    ->label('Unit Latihan')
                    ->relationship('unit', 'name')
                    ->searchable()
                    ->preload(),

                // Filter Status Verifikasi
                SelectFilter::make('verification_status')
                    ->label('Status Akun')
                    ->options([
                        'pending' => 'Menunggu Verifikasi',
                        'approved' => 'Aktif (Approved)',
                        'rejected' => 'Ditolak',
                        'incomplete' => 'Belum Lengkap',
                    ]),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
