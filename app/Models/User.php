<?php

namespace App\Models;

use Filament\Panel;
use App\Models\Level;
use App\Models\OrganizationPosition;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// class User extends Authenticatable implements MustVerifyEmail, FilamentUser
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
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

    /**
     * Helper Generic untuk cek role (Memperbaiki error hasRole)
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
