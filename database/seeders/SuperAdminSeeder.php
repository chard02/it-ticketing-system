<?php

namespace Database\Seeders;

use App\Models\Akun;
use App\Models\Level;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $pegawai = Pegawai::where(
            'nip',
            'SUPERADMIN001'
        )->first();

        $level = Level::where(
            'nama_level',
            'Super Admin'
        )->first();

        if (!$pegawai || !$level) {
            $this->command->error(
                'Pegawai atau Level Super Admin tidak ditemukan!'
            );

            return;
        }

        Akun::updateOrCreate(
            [
                'username' => 'superadmin',
            ],
            [
                'pegawai_id' => $pegawai->id,
                'level_id' => $level->id,
                'password' => Hash::make('password123'),
                'status' => 'AKTIF',
            ]
        );

        $this->command->info(
            'Akun Super Admin berhasil dibuat!'
        );
    }
}
