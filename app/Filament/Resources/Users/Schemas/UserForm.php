<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Validation\Rules\Password;
use Filament\Schemas\Components\Utilities\Get;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // SECTION 1: INFORMASI AKUN
                Section::make('Profil Akun')
                    ->description('Informasi dasar pengguna sistem.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-user'), // Gunakan prefixIcon

                        TextInput::make('username')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-at-symbol'),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-envelope'),

                        Select::make('role')
                            ->label('Hak Akses (Role)')
                            ->required()
                            ->options([
                                'admin' => 'Admin (Full Akses)',
                                'scanner' => 'Scanner (Scan Tiket)',
                                'user' => 'User (Regular)',
                            ])
                            ->default('user')
                            ->native(false) // Dropdown modern
                            ->prefixIcon('heroicon-m-key'),
                    ])
                    ->columns(2), // Grid 2 kolom agar rapi

                // SECTION 2: KEAMANAN (PASSWORD)
                Section::make('Keamanan')
                    ->description('Atur kata sandi pengguna di sini. Kosongkan jika tidak ingin mengubah.')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        TextInput::make('password')
                            ->label('Kata Sandi Baru')
                            ->password()
                            ->prefixIcon('heroicon-m-lock-closed')
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrateStateUsing(fn(?string $state): ?string => filled($state) ? Hash::make($state) : null)
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->revealable()
                            ->rule(Password::defaults())
                            ->helperText('Minimal 8 karakter.'),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi Kata Sandi')
                            ->password()
                            ->prefixIcon('heroicon-m-lock-closed')
                            ->required(fn(string $operation, Get $get): bool => $operation === 'create' || filled($get('password')))
                            ->same('password')
                            ->revealable()
                            ->dehydrated(false),
                    ])
                    ->columns(2)
                    ->collapsible(), // Bisa ditutup jika hanya edit profil
            ]);
    }
}
