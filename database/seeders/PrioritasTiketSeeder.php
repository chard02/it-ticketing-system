<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritasTiketSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_prioritas' => 'Rendah',
                'urutan' => 1,
                'keterangan' => 'Tidak mengganggu pekerjaan utama',
            ],
            [
                'nama_prioritas' => 'Sedang',
                'urutan' => 2,
                'keterangan' => 'Mengganggu sebagian pekerjaan',
            ],
            [
                'nama_prioritas' => 'Tinggi',
                'urutan' => 3,
                'keterangan' => 'Mengganggu pekerjaan utama dan perlu segera ditangani',
            ],
            [
                'nama_prioritas' => 'Darurat',
                'urutan' => 4,
                'keterangan' => 'Gangguan kritis yang membutuhkan penanganan segera',
            ],
        ];

        foreach ($data as $item) {
            DB::table('prioritas_tiket')->updateOrInsert(
                ['nama_prioritas' => $item['nama_prioritas']],
                [
                    'urutan' => $item['urutan'],
                    'keterangan' => $item['keterangan'],
                    'status' => 'AKTIF',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
