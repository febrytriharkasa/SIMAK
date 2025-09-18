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
        Schema::create('nilai_tk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa_tk')->onDelete('cascade');
            $table->foreignId('guru_id')->constrained('guru_tk')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapel_tk')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas_tk')->onDelete('cascade');
            $table->json('tugas')->nullable(); // simpan array tugas
            $table->integer('uts')->nullable();
            $table->integer('eas')->nullable();
            $table->float('nilai_akhir')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilai_tk');
    }
};
