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
        Schema::create('lampiran_tiket', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tiket_id')
                ->constrained('tiket')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('progres_tiket_id')
                ->nullable()
                ->constrained('progres_tiket')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nama_file');

            $table->string('path_file');

            $table->string('tipe_file')
                ->nullable();

            $table->unsignedBigInteger('ukuran_file')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lampiran_tiket');
    }
};
