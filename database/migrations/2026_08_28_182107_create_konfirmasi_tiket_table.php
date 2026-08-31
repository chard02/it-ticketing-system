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
        Schema::create('konfirmasi_tiket', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tiket_id')
                ->constrained('tiket')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->enum('status_konfirmasi', [
                'SELESAI',
                'BELUM_SELESAI'
            ]);

            $table->text('alasan')->nullable();

            $table->timestamp('waktu_konfirmasi')
                ->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfirmasi_tiket');
    }
};
