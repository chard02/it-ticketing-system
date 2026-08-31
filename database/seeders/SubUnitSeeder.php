<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\SubUnit;
use Illuminate\Database\Seeder;

class SubUnitSeeder extends Seeder
{
    public function run(): void
    {
        $unit = Unit::where('kode_unit', 'UNIT-001')->first();

        if (!$unit) {
            return;
        }

        SubUnit::updateOrCreate(
            [
                'kode_sub_unit' => 'SUB-001',
            ],
            [
                'unit_id' => $unit->id,
                'nama_sub_unit' => 'Head Office',
                'status' => 'AKTIF',
            ]
        );
    }
}
