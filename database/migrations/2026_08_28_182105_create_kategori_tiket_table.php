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
        Schema::create('kategori_tiket', function (Blueprint $table) {
            $table->id();

            $table->string('nama_kategori', 100)->unique();

            $table->text('keterangan')->nullable();

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
        Schema::dropIfExists('kategori_tiket');
    }
};
