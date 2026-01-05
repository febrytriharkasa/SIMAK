<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // ← tambahkan ini

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan kolom 'tahun_ajaran_id' ada
        if (!Schema::hasColumn('nilai_tk', 'tahun_ajaran_id')) {
            Schema::table('nilai_tk', function (Blueprint $table) {
                $table->unsignedBigInteger('tahun_ajaran_id')->nullable()->after('kelas_id');
            });
        }

        // Tambahkan foreign key jika belum ada
        $exists = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = 'nilai_tk' 
            AND CONSTRAINT_SCHEMA = DATABASE() 
            AND CONSTRAINT_NAME = 'nilai_tk_tahun_ajaran_id_foreign'
        ");

        if (empty($exists)) {
            Schema::table('nilai_tk', function (Blueprint $table) {
                $table->foreign('tahun_ajaran_id', 'nilai_tk_tahun_ajaran_id_foreign')
                    ->references('id')
                    ->on('tahun_ajaran_tk')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('nilai_tk', function (Blueprint $table) {
            $exists = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'nilai_tk' 
                AND CONSTRAINT_SCHEMA = DATABASE() 
                AND CONSTRAINT_NAME = 'nilai_tk_tahun_ajaran_id_foreign'
            ");

            if (!empty($exists)) {
                $table->dropForeign('nilai_tk_tahun_ajaran_id_foreign');
            }

            if (Schema::hasColumn('nilai_tk', 'tahun_ajaran_id')) {
                $table->dropColumn('tahun_ajaran_id');
            }
        });
    }
};
