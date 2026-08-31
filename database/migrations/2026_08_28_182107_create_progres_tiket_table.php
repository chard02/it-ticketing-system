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
        Schema::create('progres_tiket', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tiket_id')
                ->constrained('tiket')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Pegawai yang melakukan update
            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedTinyInteger('persentase_progres')
                ->default(0);

            $table->text('keterangan');

            $table->foreignId('status_tiket_id')
                ->constrained('status_tiket')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progres_tiket');
    }
};
