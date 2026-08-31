<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Divisi;
use Illuminate\Database\Seeder;

class DivisiSeeder extends Seeder
{
    public function run(): void
    {
        $unit = Unit::where('kode_unit', 'UNIT-001')->first();

        if (!$unit) {
            return;
        }

        Divisi::updateOrCreate(
            [
                'kode_divisi' => 'DIV-IT',
            ],
            [
                'unit_id' => $unit->id,
                'nama_divisi' => 'Information Technology',
                'status' => 'AKTIF',
            ]
        );
    }
}
