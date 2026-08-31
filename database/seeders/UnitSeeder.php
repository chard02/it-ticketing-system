<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        Unit::updateOrCreate(
            [
                'kode_unit' => 'UNIT-001',
            ],
            [
                'nama_unit' => 'Kantor Pusat',
                'status' => 'AKTIF',
            ]
        );
    }
}
