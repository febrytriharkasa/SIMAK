<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            if (!Schema::hasColumn('siswas_mi', 'tahun_ajaran_id')) {
                $table->unsignedBigInteger('tahun_ajaran_id')
                    ->nullable()
                    ->after('tahun');
            }
        });

        // Baru tambahkan foreign key kalau kolom ada tapi belum FK
        Schema::table('siswas_mi', function (Blueprint $table) {
            $sm = Schema::getColumnListing('siswas_mi');
            if (in_array('tahun_ajaran_id', $sm)) {
                $table->foreign('tahun_ajaran_id')
                    ->references('id')
                    ->on('tahun_ajaran_mi')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            if (Schema::hasColumn('siswas_mi', 'tahun_ajaran_id')) {
                $table->dropConstrainedForeignId('tahun_ajaran_id');
            }
        });
    }
};
