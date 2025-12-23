<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrganizationPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Ketua Cabang', 'order_level' => 1],
            ['name' => 'Sekretaris', 'order_level' => 2],
            ['name' => 'Bendahara', 'order_level' => 3],
            ['name' => 'Seksi Kepelatihan', 'order_level' => 4],
            ['name' => 'Seksi Pertandingan', 'order_level' => 5],
            ['name' => 'Seksi Humas', 'order_level' => 6],
        ];

        foreach ($positions as $pos) {
            OrganizationPosition::create($pos);
        }
    }
}
