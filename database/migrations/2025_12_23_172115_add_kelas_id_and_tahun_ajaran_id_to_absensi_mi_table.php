<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('absensi_mi', function (Blueprint $table) {

            $table->foreignId('kelas_id')
                ->after('siswa_id')
                ->constrained('kelas_mi')
                ->cascadeOnDelete();

            $table->foreignId('tahun_ajaran_id')
                ->after('kelas_id')
                ->constrained('tahun_ajaran_mi')
                ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('absensi_mi', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['tahun_ajaran_id']);
            $table->dropColumn(['kelas_id', 'tahun_ajaran_id']);
        });
    }
};
