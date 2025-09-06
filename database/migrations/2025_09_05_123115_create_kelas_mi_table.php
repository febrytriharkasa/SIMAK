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
        Schema::create('kelas_mi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas'); // contoh: "Kelas 1", "Kelas 2"
            $table->integer('tingkat');   // contoh: 1,2,3 dst.
            $table->timestamps();
        });

        // Tambahkan kolom relasi di tabel siswa
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->unsignedBigInteger('kelas_id')->nullable()->after('nama_wali');

            $table->foreign('kelas_id')
                  ->references('id')
                  ->on('kelas_mi')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus foreign key dan kolom dari siswas_mi
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropColumn('kelas_id');
        });

        Schema::dropIfExists('kelas_mi');
    }
};
