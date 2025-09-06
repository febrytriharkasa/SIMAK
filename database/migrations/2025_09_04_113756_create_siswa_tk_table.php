<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa_tk', function (Blueprint $table) {
            $table->id();
            $table->string('id_tk')->unique(); // No Induk
            $table->string('nama');
            $table->year('tahun'); // Tahun masuk
            $table->string('nama_wali');
            $table->string('no_hp_wali')->nullable();
            $table->text('alamat_siswa')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_tk');
    }
};
