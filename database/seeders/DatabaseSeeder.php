<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LevelSeeder::class,
            JenisTiketSeeder::class,
            PrioritasTiketSeeder::class,
            StatusTiketSeeder::class,
            UnitSeeder::class,
            SubUnitSeeder::class,
            LokasiSeeder::class,
            DivisiSeeder::class,
            JabatanSeeder::class,
            PegawaiSeeder::class,
            SuperAdminSeeder::class,
            KategoriTiketSeeder::class,
            SubKategoriTiketSeeder::class,
        ]);
    }
}