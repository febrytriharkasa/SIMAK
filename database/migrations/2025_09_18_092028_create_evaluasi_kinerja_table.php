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
        Schema::create('evaluasi_kinerja', function (Blueprint $table) {
            $table->id();

            // Relasi ke user (pegawai/guru)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Periode penilaian
            $table->string('periode'); // contoh: "Semester 1 2025"

            // Nilai per aspek (bisa ditambah sesuai kebutuhan)
            $table->integer('disiplin')->nullable();   // nilai 0-100
            $table->integer('tanggung_jawab')->nullable();
            $table->integer('kerjasama')->nullable();
            $table->integer('kompetensi')->nullable();
            $table->integer('kehadiran')->nullable();

            // Nilai akhir (rata-rata atau perhitungan lain)
            $table->integer('nilai_akhir')->nullable();

            // Kategori hasil (Sangat Baik, Baik, Cukup, Kurang)
            $table->string('kategori')->nullable();

            // Catatan tambahan
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_kinerja');
    }
};