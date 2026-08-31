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
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unit_id')
                ->constrained('unit')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('sub_unit_id')
                ->nullable()
                ->constrained('sub_unit')
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('kode_lokasi', 50)->unique();
            $table->string('nama_lokasi');

            $table->text('alamat')->nullable();

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
        Schema::dropIfExists('lokasi');
    }
};
