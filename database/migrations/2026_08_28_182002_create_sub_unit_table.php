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
        Schema::create('sub_unit', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unit_id')
                ->constrained('unit')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('kode_sub_unit', 50)->unique();
            $table->string('nama_sub_unit');

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
        Schema::dropIfExists('sub_unit');
    }
};
