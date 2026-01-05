<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas_tk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nisn')->nullable();
            $table->year('tahun')->nullable();
            $table->year('tahun_daftar')->nullable();
            $table->string('alamat_siswa')->nullable();
            $table->foreignId('kelas_id')->nullable(); // relasi ke kelas
            $table->string('bukti_pembayaran')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->nullable();
            $table->string('foto_siswa')->nullable();
            $table->foreignId('orangtua_id')->nullable(); // relasi ke User
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();
            $table->string('alamat_orangtua')->nullable();
            $table->string('no_hp_orangtua')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->decimal('penghasilan_ayah', 15, 2)->nullable();
            $table->decimal('penghasilan_ibu', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas_tk');
    }
};
