<?php

namespace App\Filament\Resources\Levels;

use BackedEnum;
use App\Models\Level;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkActionGroup;
use Filament\Forms\Components\Toggle;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use App\Filament\Resources\Levels\Pages\ManageLevels;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    // Mengubah label di Sidebar kiri
    protected static ?string $navigationLabel = 'Tingkatan';

    // Mengubah label singular (untuk tombol "New Tingkatan", dll)
    protected static ?string $modelLabel = 'Tingkatan';

    // Mengubah label plural (untuk judul tabel "Daftar Tingkatan")
    protected static ?string $pluralModelLabel = 'Data Tingkatan';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Tingkatan')
                    ->description('Atur nama tingkatan dan urutan hierarkinya.')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Tingkatan')
                            ->placeholder('Contoh: Dasar 1, Putih, Hijau')
                            ->required()
                            ->prefixIcon('heroicon-m-bookmark')
                            ->maxLength(255)
                            ->columnSpan(1), // Menggunakan 1 kolom di grid

                        TextInput::make('order')
                            ->label('Urutan (Rank)')
                            ->numeric()
                            ->default(0)
                            ->prefixIcon('heroicon-m-hashtag')
                            ->helperText('Angka 1 adalah tingkatan terendah, dst.')
                            ->columnSpan(1),

                        Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true)
                            ->columnSpanFull(), // Toggle memanjang penuh
                    ])
                    ->columns(2), // Membagi section menjadi 2 kolom
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('order', 'asc')
            ->recordTitleAttribute('name')
            ->columns([
                // TextColumn::make('order')->sortable(),
                TextColumn::make('name')
                    ->label('Nama Tingkatan')
                    ->weight(FontWeight::Bold) // Teks tebal agar lebih jelas
                    ->searchable()
                    ->icon('heroicon-m-bookmark-square')
                    ->iconColor('primary'),

                IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueColor('success')  // Hijau jika aktif
                    ->falseColor('danger') // Merah jika tidak aktif
                    ->alignCenter(),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => ManageLevels::route('/'),
        ];
    }
}
