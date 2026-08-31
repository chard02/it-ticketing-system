<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();

            $table->string('nip', 50)->unique();
            $table->string('nama');

            $table->string('email')->nullable()->unique();
            $table->string('nomor_telepon', 30)->nullable();

            $table->string('foto')->nullable();

            $table->enum('jenis_kelamin', [
                'LAKI_LAKI',
                'PEREMPUAN'
            ]);

            $table->foreignId('unit_id')
                ->constrained('unit')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('sub_unit_id')
                ->nullable()
                ->constrained('sub_unit')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('divisi_id')
                ->nullable()
                ->constrained('divisi')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('jabatan_id')
                ->nullable()
                ->constrained('jabatan')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('lokasi_id')
                ->nullable()
                ->constrained('lokasi')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->enum('status', ['AKTIF', 'TIDAK_AKTIF'])
                ->default('AKTIF');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
