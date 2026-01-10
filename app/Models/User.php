<?php

namespace App\Models;

use Filament\Panel;
use App\Models\Level;
use App\Models\UserVerification;
use Spatie\MediaLibrary\HasMedia;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\OrganizationPosition;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable implements MustVerifyEmail, FilamentUser
class User extends Authenticatable implements FilamentUser, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nia',
        'name',
        'username',
        'role',
        'email',
        'password',
        'nik',
        'place_of_birth',
        'date_of_birth',
        'gender',
        'phone_number',
        'address',
        'job',
        'join_year',
        'level_id',
        'unit_id',
        'verification_status',
        'rejection_note',
        'organization_position_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }

    // Relasi ke Event (jika user membuat event)
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // Relasi ke Order (jika user membeli tiket)
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Helper Cek Role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCoach()
    {
        return $this->role === 'coach';
    }

    public function isScanner(): bool
    {
        return $this->role === 'scanner';
    }

    // Filament Panel Access
    public function canAccessPanel(Panel $panel): bool
    {
        // Admin dan Coach bisa masuk panel admin
        if ($panel->getId() === 'admin') {
            return $this->isAdmin() || $this->isScanner();
        }
        return false;
    }


    /**
     * Mendapatkan nama panggilan yang disesuaikan.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $words = explode(' ', $attributes['name']);
                $displayName = $words[0] ?? ''; // Default-nya kata pertama

                foreach ($words as $word) {
                    // Cari kata pertama yang kurang dari 7 huruf
                    if (strlen($word) < 7) {
                        $displayName = $word;
                        break;
                    }
                }

                return $displayName;
            }
        );
    }

    public function getFilamentName(): string
    {
        // Ini akan menampilkan nama lengkap.
        // Jika ingin huruf kapital semua: return strtoupper($this->name);
        return $this->name;
    }

    // Relasi Atlet -> Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // Relasi Pelatih -> Units (Many to Many)
    public function coachedUnits()
    {
        return $this->belongsToMany(Unit::class, 'coach_unit');
    }

    // Relasi ke Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Relasi langsung ke Jabatan
    public function organizationPosition()
    {
        return $this->belongsTo(OrganizationPosition::class, 'organization_position_id');
    }

    // Helper untuk mengambil nama level (Safe Access)
    public function getLevelNameAttribute()
    {
        return $this->level ? $this->level->name : '-';
    }

    // Relasi ke history verifikasi
    public function verifications()
    {
        return $this->hasMany(UserVerification::class)->latest();
    }

    // Helper untuk mengambil verifikasi terakhir
    public function latestVerification()
    {
        return $this->hasOne(UserVerification::class)->latestOfMany();
    }

    /**
     * Daftar kolom yang jika berubah, mempengaruhi status verifikasi.
     * Sesuaikan dengan form profile Anda.
     */
    public const VERIFIABLE_ATTRIBUTES = [
        'name',
        'nik',
        'place_of_birth',
        'date_of_birth',
        'gender',
        // 'address',
        // 'job',
        'unit_id',   // Unit latihan
        'level_id',  // Tingkatan sabuk
        'join_year',
        // 'phone_number' // Opsional: mau pending ulang kalau ganti HP? Jika ya, masukkan.
    ];

    /**
     * Helper Generic untuk cek role (Memperbaiki error hasRole)
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Konfigurasi Spatie Media Library
     */
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('profile_photo')
            ->singleFile() // Hapus foto lama otomatis saat upload baru
            ->useDisk('public'); // Simpan di storage/app/public
    }

    /**
     * Helper untuk mendapatkan URL foto profil atau Fallback (Inisial Nama)
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('profile_photo')
            ?: 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
}
