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
        Schema::create('tiket', function (Blueprint $table) {
            $table->id();

            $table->string('nomor_tiket', 50)->unique();

            $table->string('judul');

            $table->text('deskripsi');

            $table->foreignId('jenis_tiket_id')
                ->constrained('jenis_tiket')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('kategori_tiket_id')
                ->constrained('kategori_tiket')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('sub_kategori_tiket_id')
                ->nullable()
                ->constrained('sub_kategori_tiket')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('prioritas_tiket_id')
                ->nullable()
                ->constrained('prioritas_tiket')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('status_tiket_id')
                ->constrained('status_tiket')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Pegawai yang membuat tiket
            $table->foreignId('pelapor_id')
                ->constrained('pegawai')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('teknisi_id')
                ->nullable()
                ->constrained('pegawai')
                ->cascadeOnUpdate()
                ->nullOnDelete();


            $table->foreignId('unit_id')
                ->nullable()
                ->constrained('unit')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('lokasi_id')
                ->nullable()
                ->constrained('lokasi')
                ->cascadeOnUpdate()
                ->nullOnDelete();


            $table->timestamp('waktu_ditugaskan')->nullable();

            $table->timestamp('waktu_diproses')->nullable();

            $table->timestamp('waktu_selesai')->nullable();

            $table->timestamp('waktu_ditutup')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiket');
    }
};
