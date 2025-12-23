<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Informasi Unit')
                ->description('Lengkapi data identitas unit latihan atau sekolah.')
                ->icon('heroicon-o-building-library') // Ikon section
                ->schema([
                    TextInput::make('name')
                        ->label('Nama Unit / Sekolah')
                        ->required()
                        ->placeholder('Contoh: SMAN 1 Tasikmalaya')
                        ->prefixIcon('heroicon-m-building-office-2') // Ikon input
                        ->maxLength(255),

                    Select::make('type')
                        ->label('Kategori')
                        ->options([
                            'unit' => 'Unit',
                            'ranting' => 'Ranting / Sekolah',
                            'instansi' => 'Instansi / Perusahaan',
                        ])
                        ->required()
                        ->native(false) // Menggunakan UI modern, bukan select browser biasa
                        ->prefixIcon('heroicon-m-tag'),

                    Textarea::make('address')
                        ->label('Alamat Lengkap')
                        ->placeholder('Masukkan alamat lengkap lokasi latihan...')
                        ->rows(3)
                        ->autosize()
                        ->columnSpanFull(), // Membuat alamat selebar penuh
                ])
                ->columns(2), // Membagi layout menjadi 2 kolom
        ]);
    }
}
