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
        Schema::table('siswas_mi', function (Blueprint $table) {
            // Cek dulu kalau kolom belum ada
            if (!Schema::hasColumn('siswas_mi', 'tahun_ajaran_id')) {
                $table->foreignId('tahun_ajaran_id')
                      ->nullable()
                      ->after('tahun')
                      ->constrained('tahun_ajaran_mi')
                      ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            // Hapus kolom kalau ada
            if (Schema::hasColumn('siswas_mi', 'tahun_ajaran_id')) {
                $table->dropConstrainedForeignId('tahun_ajaran_id');
            }
        });
    }
};
