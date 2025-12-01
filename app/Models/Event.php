<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'location',
        'location_map_link',
        'ticket_price',
        'event_type',
        'has_dynamic_pricing',
        'level_prices',
        'ticket_quota',
        'ticket_sold',
        'starts_at',
        'ends_at',
        'contact_person_name',
        'contact_person_phone',
        'certificate_template',     // <-- Baru
        'certificate_settings',     // <-- Baru
        'is_certificate_published', // <-- Baru
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'has_dynamic_pricing' => 'boolean',
        'level_prices' => 'array',
        'certificate_settings' => 'array',    // <-- Baru (Cast JSON ke Array)
        'is_certificate_published' => 'boolean', // <-- Baru (Cast Tinyint ke Boolean)
    ];

    // Relasi ke User (pembuat event)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Order
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Konfigurasi Spatie Media Library
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('thumbnails')->singleFile(); // Untuk gambar utama
        $this->addMediaCollection('certificate_template')->singleFile();
        $this->addMediaCollection('gallery'); // Untuk galeri
    }


    /**
     * Helper method UNIVERSAL untuk mendapatkan harga tiket.
     *
     * @param string|null $level Tingkatan sabuk (untuk ujian).
     * @param string|null $category Kategori pertandingan.
     * @return float|null Harga tiket atau null jika tidak valid.
     */

    public function getPrice(?string $level = null, ?string $category = null): ?float
    {
        // 1. Jika tidak pakai harga dinamis sama sekali
        if (!$this->has_dynamic_pricing) {
            return (float) $this->ticket_price;
        }

        // 2. Jika pakai harga dinamis, cek tipe event
        $prices = $this->level_prices ?? []; // Ambil array harga

        // Jika tipe 'ujian' dan ada tingkatan dipilih
        if ($this->event_type === 'ujian' && !empty($level)) {
            // Logika harga ujian
            if (in_array($level, ['Pemula', 'Dasar I', 'Dasar II'])) {
                return isset($prices['pemula_dasar2']) ? (float) $prices['pemula_dasar2'] : null;
            } elseif (in_array($level, ['Cakel', 'Putih'])) {
                return isset($prices['cakel_putih']) ? (float) $prices['cakel_putih'] : null;
            } elseif (in_array($level, ['Putih Hijau', 'Hijau'])) {
                return isset($prices['putihhijau_hijau']) ? (float) $prices['putihhijau_hijau'] : null;
            }
        }
        // Jika tipe 'pertandingan' dan ada kategori dipilih
        elseif ($this->event_type === 'pertandingan' && !empty($category)) {
            // Cari harga berdasarkan key kategori di JSON (misal: 'tanding', 'tgr', 'serang_hindar')
            // Pastikan key ini sama dengan yang Anda simpan di Filament
            $categoryKey = strtolower(str_replace(' ', '_', $category)); // 'Serang Hindar' -> 'serang_hindar'
            return isset($prices[$categoryKey]) ? (float) $prices[$categoryKey] : null;
        }

        // Jika kondisi tidak terpenuhi (misal level/kategori kosong), kembalikan null atau harga dasar
        return null;
    }
}
