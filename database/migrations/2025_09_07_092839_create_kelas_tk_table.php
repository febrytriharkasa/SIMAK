<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('kelas_tk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->integer('tingkat');
            $table->timestamps();
        });

        // Tambahkan kolom relasi di tabel siswa_tk
        Schema::table('siswa_tk', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')->nullable()->after('nama_wali');

            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas_tk')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key dan kolom dari siswa_tk
        Schema::table('siswa_tk', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        Schema::dropIfExists('kelas_tk');
    }
};
