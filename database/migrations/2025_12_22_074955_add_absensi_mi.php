<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensi_mi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')
                  ->constrained('siswas_mi')
                  ->onDelete('cascade');

            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa']);
            $table->string('keterangan')->nullable();

            $table->timestamps();

            // mencegah siswa absen dua kali di tanggal yang sama
            $table->unique(['siswa_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi_mi');
    }
};
