<?php

namespace App\Services;

use Filament\Forms\Components\TextInput;

class ExamConfig
{
    /**
     * Mendapatkan schema form penilaian berdasarkan tingkatan.
     */
    public static function getScoreSchema(string $level): array
    {
        // Normalisasi level (lowercase, trim) untuk comparison
        $level = strtolower(trim($level));

        $schema = [];

        // 1. Pemula - Dasar I
        if (in_array($level, ['pemula', 'dasar i'])) {
            $schema = [
                self::makeInput('sb', 'Teknik Senam Berantai'),
                self::makeInput('sk', 'Teknik Senam Kombinasi'),
                self::makeInput('serang', 'Teknik Dasar Serang'),
                self::makeInput('hindar', 'Teknik Dasar Hindar'),
                self::makeInput('fisik', 'Fisik'),
                self::makeInput('teori', 'Teori & Sejarah Perisai Diri'),
            ];
        }
        // 2. Dasar II
        elseif ($level === 'dasar ii') {
            $schema = [
                self::makeInput('solospel', 'SOLOSPEL'),
                self::makeInput('sk', 'Teknik Senam Kombinasi'),
                self::makeInput('serang', 'Teknik Dasar Serang'),
                self::makeInput('hindar', 'Teknik Dasar Hindar'),
                self::makeInput('fisik', 'Fisik'),
                self::makeInput('teori', 'Teori & Sejarah Perisai Diri'),
            ];
        }
        // 3. Cakel
        elseif ($level === 'cakel') {
            $schema = [
                self::makeInput('solospel', 'SOLOSPEL'),
                self::makeInput('sk', 'Teknik Senam Kombinasi'),
                self::makeInput('serang', 'Teknik Dasar Serang'),
                self::makeInput('hindar', 'Teknik Dasar Hindar'),
                self::makeInput('tarung', 'Tarung'),
                self::makeInput('fisik', 'Fisik'),
                self::makeInput('teori', 'Teori & Sejarah Perisai Diri'),
            ];
        }
        // 4. Putih, Putih Hijau, Hijau
        elseif (in_array($level, ['putih', 'putih hijau', 'hijau'])) {
            $schema = [
                self::makeInput('solospel', 'SOLOSPEL'),
                self::makeInput('teknik_asli', 'Teknik Asli'),
                self::makeInput('serang', 'Teknik Dasar Serang'),
                self::makeInput('hindar', 'Teknik Dasar Hindar'),
                self::makeInput('tarung', 'Tarung'),
                self::makeInput('teknik_senjata', 'Teknik Senjata'),
            ];
        }

        return $schema;
    }

    // Helper untuk membuat input standar
    private static function makeInput($key, $label)
    {
        return TextInput::make("scores.{$key}") // Simpan ke dalam JSON 'scores'
            ->label($label)
            ->numeric()
            ->maxValue(100)
            ->required();
    }
}
