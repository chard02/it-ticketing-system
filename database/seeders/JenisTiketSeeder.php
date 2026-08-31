<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTiketSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_jenis' => 'Gangguan',
                'keterangan' => 'Laporan masalah atau kerusakan pada perangkat maupun sistem',
            ],
            [
                'nama_jenis' => 'Permintaan',
                'keterangan' => 'Permintaan layanan, perangkat, aplikasi, atau akses',
            ],
        ];

        foreach ($data as $item) {
            DB::table('jenis_tiket')->updateOrInsert(
                ['nama_jenis' => $item['nama_jenis']],
                [
                    'keterangan' => $item['keterangan'],
                    'status' => 'AKTIF',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
