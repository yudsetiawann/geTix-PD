<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Validation\Rules\Password;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\DatePicker; // Tambahan
use Filament\Schemas\Components\Grid;     // Tambahan

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // SECTION 1: INFORMASI AKUN
                Section::make('Profil Akun')
                    ->description('Informasi dasar login dan hak akses.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255)
                            ->prefixIcon('heroicon-m-user'),

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
                                'admin'   => 'Admin (Full Akses)',
                                'coach'   => 'Coach (Pelatih)',
                                'scanner' => 'Scanner (Scan Tiket)',
                                'user'    => 'User (Atlet/Anggota)',
                            ])
                            ->default('user')
                            ->native(false)
                            ->prefixIcon('heroicon-m-key')
                            ->live(), // PENTING: Agar form lain bereaksi saat role berubah
                    ])
                    ->columns(2),

                // SECTION 2: BIODATA PRIBADI
                Section::make('Biodata Pribadi')
                    ->description('Data diri lengkap sesuai KTP/Identitas.')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nik')
                                ->label('NIK')
                                ->regex('/^[0-9]+$/') // Hanya izinkan angka 0-9
                                ->length(16)
                                ->validationMessages([
                                    'regex' => 'NIK hanya boleh berisi angka.',
                                ])
                                ->unique(ignoreRecord: true),

                            TextInput::make('phone_number')
                                ->label('No. WhatsApp')
                                ->tel()
                                ->maxLength(20),

                            TextInput::make('place_of_birth')
                                ->label('Tempat Lahir'),

                            DatePicker::make('date_of_birth')
                                ->label('Tanggal Lahir')
                                ->displayFormat('d F Y') // Format tampilan
                                ->native(false),

                            Select::make('gender')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'L' => 'Laki-laki',
                                    'P' => 'Perempuan',
                                ]),

                            TextInput::make('job')
                                ->label('Pekerjaan / Sekolah'),
                        ]),

                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // SECTION 3: DATA ORGANISASI
                Section::make('Data Organisasi')
                    ->description('Informasi keanggotaan Perisai Diri.')
                    ->icon('heroicon-o-academic-cap')
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nia')
                                ->label('Nomor Induk Anggota (NIA)')
                                // 1. Kunci field agar tidak bisa diketik langsung (mencegah typo tidak sengaja)
                                ->readOnly()

                                // 2. Tambahkan tombol aksi di ujung kanan input
                                ->suffixAction(
                                    Action::make('force_edit_nia')
                                        ->icon('heroicon-m-pencil-square')
                                        ->color('warning') // Warna kuning menandakan "Hati-hati"
                                        ->tooltip('Ubah NIA secara manual (Khusus Admin)')

                                        // 3. INI POP-UP KONFIRMASINYA
                                        ->requiresConfirmation()
                                        ->modalHeading('Ubah NIA Manual')
                                        ->modalDescription('PERHATIAN: NIA dihasilkan otomatis oleh sistem berdasarkan urutan. Mengubahnya secara manual berisiko menyebabkan duplikasi atau ketidaksesuaian data. Apakah Anda yakin?')
                                        ->modalSubmitActionLabel('Ya, Saya Yakin')

                                        // 4. Form input di dalam Pop-up
                                        ->fillForm(fn($record) => ['new_nia' => $record?->nia])
                                        ->form([
                                            TextInput::make('new_nia')
                                                ->label('Masukkan NIA Baru')
                                                ->required()
                                                ->maxLength(20)
                                                ->helperText('Pastikan format sesuai: YYYY + DDMMYYYY + XXXX'),
                                        ])

                                        // 5. Eksekusi perubahan nilai ke form utama
                                        ->action(function (Set $set, array $data) {
                                            $set('nia', $data['new_nia']);
                                        })
                                )
                                // Pastikan tetap divalidasi unique ke database saat form utama disimpan
                                ->unique(table: 'users', column: 'nia', ignoreRecord: true)
                                ->maxLength(20)
                                // PENTING: dehydrated true agar nilai yang di-set manual ikut tersimpan ke DB
                                ->dehydrated(true)
                                ->columnSpanFull(),

                            // Level / Sabuk (Relasi ke tabel levels)
                            Select::make('level_id')
                                ->label('Tingkatan')
                                ->relationship('level', 'name', fn($query) => $query->orderBy('order', 'asc'))
                                ->searchable()
                                ->preload(),

                            TextInput::make('join_year')
                                ->label('Tahun Masuk')
                                ->numeric()
                                ->minValue(1955)
                                ->maxValue(date('Y')),

                            // LOGIC: Unit Latihan (Hanya untuk User/Atlet)
                            Select::make('unit_id')
                                ->label('Unit Latihan Utama')
                                ->relationship('unit', 'name')
                                ->searchable()
                                ->preload()
                                ->visible(fn(Get $get) => $get('role') === 'user' || $get('role') === null)
                                ->helperText('Unit tempat atlet berlatih.'),

                            // LOGIC: Unit Binaan (Hanya untuk Coach) - Many to Many
                            Select::make('coachedUnits')
                                ->label('Unit Binaan (Tempat Melatih)')
                                ->relationship('coachedUnits', 'name') // Relasi belongsToMany di Model User
                                ->multiple()
                                ->searchable()
                                ->preload()
                                ->visible(fn(Get $get) => $get('role') === 'coach')
                                ->helperText('Pilih unit mana saja yang dilatih oleh pelatih ini.'),
                        ]),

                        // Status Verifikasi
                        Select::make('verification_status')
                            ->label('Status Verifikasi')
                            ->options([
                                'incomplete' => 'Incomplete (Data Belum Lengkap)',
                                'pending'    => 'Pending (Menunggu ACC)',
                                'approved'   => 'Approved (Aktif)',
                                'rejected'   => 'Rejected (Ditolak)',
                            ])
                            ->default('incomplete')
                            ->native(false)
                            ->live(), // Reaktif untuk rejection note

                        Textarea::make('rejection_note')
                            ->label('Alasan Penolakan')
                            ->visible(fn(Get $get) => $get('verification_status') === 'rejected')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // SECTION 4: KEAMANAN (PASSWORD)
                Section::make('Keamanan')
                    ->description('Atur kata sandi pengguna.')
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
                    ->collapsible(),
            ]);
    }
}
