<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = [
            1 => 'Pemula',
            2 => 'Dasar I',
            3 => 'Dasar II',
            4 => 'Cakel',
            5 => 'Putih',
            6 => 'Putih Hijau',
            7 => 'Hijau',
            8 => 'Hijau Biru',
            9 => 'Biru',
            10 => 'Biru Merah',
            11 => 'Merah',
            12 => 'Merah Kuning',
            13 => 'Kuning',
            14 => 'Pendekar',
        ];

        foreach ($levels as $order => $name) {
            Level::create([
                'name' => $name,
                'order' => $order,
                'is_active' => true,
            ]);
        }
    }
}
