<?php

namespace Database\Seeders;

use App\Models\ExamLevel;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            'Pemula - Dasar I' => ['Teknik Senam Berantai', 'Teknik Senam Kombinasi', 'Teknik Dasar Serang', 'Teknik Dasar Hindar', 'Fisik', 'Teori & Sejarah Perisai Diri'],
            'Dasar II' => ['SOLOSPEL', 'Teknik Senam Kombinasi', 'Teknik Dasar Serang', 'Teknik Dasar Hindar', 'Fisik', 'Teori & Sejarah Perisai Diri'],
            'Cakel' => ['SOLOSPEL', 'Teknik Senam Kombinasi', 'Teknik Dasar Serang', 'Teknik Dasar Hindar', 'Tarung', 'Fisik', 'Teori & Sejarah Perisai Diri'],
            'Putih - Hijau' => ['SOLOSPEL', 'Teknik Asli', 'Teknik Dasar Serang', 'Teknik Dasar Hindar', 'Tarung', 'Teknik Senjata'],
        ];

        foreach ($levels as $name => $attrs) {
            $level = ExamLevel::create(['name' => $name]);
            foreach ($attrs as $index => $attrName) {
                $level->attributes()->create([
                    'name' => $attrName,
                    'order' => $index + 1
                ]);
            }
        }
    }
}
