<?php

namespace Database\Seeders;

use App\Models\KategoriTiket;
use App\Models\SubKategoriTiket;
use Illuminate\Database\Seeder;

class SubKategoriTiketSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Hardware' => [
                'Komputer / PC',
                'Laptop',
                'Monitor',
                'Keyboard',
                'Mouse',
                'UPS',
                'Komponen Hardware',
            ],

            'Software' => [
                'Windows',
                'Microsoft Office',
                'Aplikasi Desktop',
                'Aplikasi Mobile',
                'Instalasi Software',
                'Update Software',
                'Error Software',
            ],

            'Jaringan' => [
                'Internet',
                'WiFi',
                'LAN',
                'VPN',
                'IP Address',
                'Koneksi Jaringan',
            ],

            'Akun & Akses' => [
                'Reset Password',
                'Akun User',
                'Hak Akses',
                'Email',
                'Akses Sistem',
            ],

            'Printer' => [
                'Printer Tidak Bisa Mencetak',
                'Printer Offline',
                'Paper Jam',
                'Tinta / Toner',
                'Scanner',
            ],

            'Sistem Informasi' => [
                'Error Sistem',
                'Tidak Bisa Login',
                'Data Tidak Sesuai',
                'Fitur Tidak Berfungsi',
                'Permintaan Perubahan',
            ],

            'Lainnya' => [
                'Permasalahan Lainnya',
                'Permintaan Bantuan IT',
            ],
        ];

        foreach ($data as $namaKategori => $subKategoriList) {

            $kategori = KategoriTiket::where(
                'nama_kategori',
                $namaKategori
            )->first();

            if (!$kategori) {
                continue;
            }

            foreach ($subKategoriList as $namaSubKategori) {

                SubKategoriTiket::updateOrCreate(
                    [
                        'kategori_tiket_id' => $kategori->id,
                        'nama_sub_kategori' => $namaSubKategori,
                    ],
                    [
                        'keterangan' => null,
                        'status' => 'AKTIF',
                    ]
                );
            }
        }
    }
}
