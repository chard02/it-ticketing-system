<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\SubUnit;
use App\Models\Divisi;
use App\Models\Jabatan;
use App\Models\Lokasi;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        $unit = Unit::where('kode_unit', 'UNIT-001')->first();

        $subUnit = SubUnit::where(
            'kode_sub_unit',
            'SUB-001'
        )->first();

        $divisi = Divisi::where(
            'kode_divisi',
            'DIV-IT'
        )->first();

        $lokasi = Lokasi::where(
            'kode_lokasi',
            'LOK-001'
        )->first();

        if (!$unit) {
            return;
        }

        $data = [
            [
                'nip' => 'SUPERADMIN001',
                'nama' => 'Super Administrator',
                'email' => 'superadmin@ticketing.local',
                'jenis_kelamin' => 'LAKI_LAKI',
                'kode_jabatan' => 'JBT-SUPERADMIN',
            ],
            [
                'nip' => 'ADMINIT001',
                'nama' => 'Administrator IT',
                'email' => 'admin@ticketing.local',
                'jenis_kelamin' => 'LAKI_LAKI',
                'kode_jabatan' => 'JBT-ADMIN',
            ],
            [
                'nip' => 'MANAGERIT001',
                'nama' => 'Manager IT',
                'email' => 'manager@ticketing.local',
                'jenis_kelamin' => 'LAKI_LAKI',
                'kode_jabatan' => 'JBT-MANAGER',
            ],
            [
                'nip' => 'TEKNISI001',
                'nama' => 'Teknisi IT',
                'email' => 'teknisi@ticketing.local',
                'jenis_kelamin' => 'LAKI_LAKI',
                'kode_jabatan' => 'JBT-TEKNISI',
            ],
            [
                'nip' => 'PEGAWAI001',
                'nama' => 'Pegawai Contoh',
                'email' => 'pegawai@ticketing.local',
                'jenis_kelamin' => 'PEREMPUAN',
                'kode_jabatan' => 'JBT-PEGAWAI',
            ],
        ];

        foreach ($data as $item) {

            $jabatan = Jabatan::where(
                'kode_jabatan',
                $item['kode_jabatan']
            )->first();

            Pegawai::updateOrCreate(
                [
                    'nip' => $item['nip'],
                ],
                [
                    'nama' => $item['nama'],
                    'email' => $item['email'],
                    'nomor_telepon' => null,
                    'foto' => null,
                    'jenis_kelamin' => $item['jenis_kelamin'],

                    'unit_id' => $unit->id,
                    'sub_unit_id' => $subUnit?->id,
                    'divisi_id' => $divisi?->id,
                    'jabatan_id' => $jabatan?->id,
                    'lokasi_id' => $lokasi?->id,

                    'status' => 'AKTIF',
                ]
            );
        }
    }
}
