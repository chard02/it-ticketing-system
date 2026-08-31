<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_level' => 'Super Admin',
                'keterangan' => 'Memiliki akses penuh ke sistem',
                'status' => 'AKTIF',
            ],
            [
                'nama_level' => 'Admin IT',
                'keterangan' => 'Mengelola tiket dan master data ticketing',
                'status' => 'AKTIF',
            ],
            [
                'nama_level' => 'Manager IT',
                'keterangan' => 'Memantau dan mengelola proses ticketing',
                'status' => 'AKTIF',
            ],
            [
                'nama_level' => 'Teknisi',
                'keterangan' => 'Menangani dan memperbarui progres tiket',
                'status' => 'AKTIF',
            ],
            [
                'nama_level' => 'Pegawai',
                'keterangan' => 'Membuat dan mengonfirmasi tiket',
                'status' => 'AKTIF',
            ],
        ];

        foreach ($data as $item) {
            DB::table('level')->updateOrInsert(
                ['nama_level' => $item['nama_level']],
                [
                    'keterangan' => $item['keterangan'],
                    'status' => $item['status'],
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }
    }
}
