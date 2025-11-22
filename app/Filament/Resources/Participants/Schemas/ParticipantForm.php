<?php

namespace App\Filament\Resources\Participants\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ParticipantForm // <--- Pastikan ini ParticipantForm, JANGAN UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Biodata Peserta')
                    ->description('Lengkapi data diri peserta di bawah ini.')
                    ->icon('heroicon-o-user-group')
                    ->schema([

                        // Baris 1: Nama
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Ahmad Dahlan')
                            ->prefixIcon('heroicon-m-user')
                            ->columnSpan(1),

                        // Baris 1: Sekolah
                        TextInput::make('school')
                            ->label('Asal Ranting / Sekolah')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: SMA Muhammadiyah 1')
                            ->prefixIcon('heroicon-m-building-library')
                            ->columnSpan(1),

                        // Baris 2: Tingkatan
                        Select::make('level')
                            ->label('Tingkatan')
                            ->native(false)
                            ->searchable()
                            ->options([
                                'Pemula' => 'Pemula',
                                'Dasar I' => 'Dasar I',
                                'Dasar II' => 'Dasar II',
                                'Cakel' => 'Cakel',
                                'Putih' => 'Putih',
                                'Putih Hijau' => 'Putih Hijau',
                                'Hijau' => 'Hijau',
                                'Hijau Biru' => 'Hijau Biru',
                                'Biru' => 'Biru',
                            ])
                            ->prefixIcon('heroicon-m-trophy')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
