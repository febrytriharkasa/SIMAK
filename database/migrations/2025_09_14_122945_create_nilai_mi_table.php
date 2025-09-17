<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai_mi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas_mi')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('gurus_mi')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapel_mi')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas_mi')->onDelete('cascade');
            $table->json('tugas')->nullable(); // simpan array tugas
            $table->integer('uts')->nullable();
            $table->integer('eas')->nullable();
            $table->float('nilai_akhir')->nullable(); // otomatis dihitung
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_mi');
    }
};
