<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTiketSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_status' => 'BARU',
                'urutan' => 1,
                'keterangan' => 'Tiket baru dibuat oleh pegawai',
            ],
            [
                'nama_status' => 'DITUGASKAN',
                'urutan' => 2,
                'keterangan' => 'Tiket telah ditugaskan kepada teknisi',
            ],
            [
                'nama_status' => 'DIPROSES',
                'urutan' => 3,
                'keterangan' => 'Tiket sedang dikerjakan oleh teknisi',
            ],
            [
                'nama_status' => 'PENDING',
                'urutan' => 4,
                'keterangan' => 'Pengerjaan sementara ditunda karena menunggu sesuatu',
            ],
            [
                'nama_status' => 'MENUNGGU KONFIRMASI',
                'urutan' => 5,
                'keterangan' => 'Teknisi telah menyelesaikan pekerjaan dan menunggu konfirmasi pelapor',
            ],
            [
                'nama_status' => 'SELESAI',
                'urutan' => 6,
                'keterangan' => 'Pelapor telah mengonfirmasi bahwa masalah selesai',
            ],
            [
                'nama_status' => 'DIBUKA KEMBALI',
                'urutan' => 7,
                'keterangan' => 'Pelapor menyatakan masalah belum selesai',
            ],
            [
                'nama_status' => 'DITUTUP',
                'urutan' => 8,
                'keterangan' => 'Tiket telah ditutup secara resmi',
            ],
            [
                'nama_status' => 'DIBATALKAN',
                'urutan' => 9,
                'keterangan' => 'Tiket dibatalkan',
            ],
        ];

        foreach ($data as $item) {
            DB::table('status_tiket')->updateOrInsert(
                ['nama_status' => $item['nama_status']],
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
