<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\SubUnit;
use App\Models\Lokasi;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    public function run(): void
    {
        $unit = Unit::where('kode_unit', 'UNIT-001')->first();

        $subUnit = SubUnit::where(
            'kode_sub_unit',
            'SUB-001'
        )->first();

        if (!$unit) {
            return;
        }

        Lokasi::updateOrCreate(
            [
                'kode_lokasi' => 'LOK-001',
            ],
            [
                'unit_id' => $unit->id,
                'sub_unit_id' => $subUnit?->id,
                'nama_lokasi' => 'Kantor Pusat',
                'alamat' => 'Kantor Pusat Perusahaan',
                'status' => 'AKTIF',
            ]
        );
    }
}
