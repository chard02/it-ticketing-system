<?php

namespace Database\Seeders;

use App\Models\KategoriTiket;
use Illuminate\Database\Seeder;

class KategoriTiketSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_kategori' => 'Hardware',
                'keterangan' => 'Permasalahan perangkat keras komputer dan perangkat pendukung.',
                'status' => 'AKTIF',
            ],
            [
                'nama_kategori' => 'Software',
                'keterangan' => 'Permasalahan aplikasi, sistem operasi, dan perangkat lunak.',
                'status' => 'AKTIF',
            ],
            [
                'nama_kategori' => 'Jaringan',
                'keterangan' => 'Permasalahan jaringan internet, LAN, WiFi, dan konektivitas.',
                'status' => 'AKTIF',
            ],
            [
                'nama_kategori' => 'Akun & Akses',
                'keterangan' => 'Permasalahan akun, password, hak akses, dan akses sistem.',
                'status' => 'AKTIF',
            ],
            [
                'nama_kategori' => 'Printer',
                'keterangan' => 'Permasalahan printer, scanner, dan perangkat pencetakan.',
                'status' => 'AKTIF',
            ],
            [
                'nama_kategori' => 'Sistem Informasi',
                'keterangan' => 'Permasalahan pada sistem atau aplikasi informasi perusahaan.',
                'status' => 'AKTIF',
            ],
            [
                'nama_kategori' => 'Lainnya',
                'keterangan' => 'Permasalahan IT lainnya yang tidak termasuk kategori di atas.',
                'status' => 'AKTIF',
            ],
        ];

        foreach ($data as $item) {
            KategoriTiket::updateOrCreate(
                [
                    'nama_kategori' => $item['nama_kategori'],
                ],
                $item
            );
        }
    }
}
