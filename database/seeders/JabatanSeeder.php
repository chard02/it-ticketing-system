<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\Jabatan;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run(): void
    {
        $unit = Unit::where('kode_unit', 'UNIT-001')->first();

        if (!$unit) {
            return;
        }

        $data = [
            [
                'kode_jabatan' => 'JBT-SUPERADMIN',
                'nama_jabatan' => 'Super Administrator',
            ],
            [
                'kode_jabatan' => 'JBT-ADMIN',
                'nama_jabatan' => 'Admin IT',
            ],
            [
                'kode_jabatan' => 'JBT-MANAGER',
                'nama_jabatan' => 'Manager IT',
            ],
            [
                'kode_jabatan' => 'JBT-TEKNISI',
                'nama_jabatan' => 'Teknisi IT',
            ],
            [
                'kode_jabatan' => 'JBT-PEGAWAI',
                'nama_jabatan' => 'Pegawai',
            ],
        ];

        foreach ($data as $item) {
            Jabatan::updateOrCreate(
                [
                    'kode_jabatan' => $item['kode_jabatan'],
                ],
                [
                    'unit_id' => $unit->id,
                    'nama_jabatan' => $item['nama_jabatan'],
                    'status' => 'AKTIF',
                ]
            );
        }
    }
}
