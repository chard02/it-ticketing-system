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
        Schema::create('akun', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignId('level_id')
                ->constrained('level')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('username')->unique();

            $table->string('password');

            $table->timestamp('terakhir_login')->nullable();

            $table->string('ip_login', 50)->nullable();

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
        Schema::dropIfExists('akun');
    }
};
