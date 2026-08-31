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
        Schema::create('sub_kategori_tiket', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_tiket_id')
                ->constrained('kategori_tiket')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('nama_sub_kategori', 100);

            $table->text('keterangan')->nullable();

            $table->enum('status', ['AKTIF', 'TIDAK_AKTIF'])
                ->default('AKTIF');

            $table->timestamps();
            $table->softDeletes();

            $table->unique([
                'kategori_tiket_id',
                'nama_sub_kategori'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategori_tiket');
    }
};
