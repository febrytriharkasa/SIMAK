<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom jika belum ada
        Schema::table('siswa_tk', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa_tk', 'tahun_ajaran_id')) {
                $table->unsignedBigInteger('tahun_ajaran_id')
                      ->after('tahun')
                      ->nullable();
            }
        });

        // Isi data lama
        if (Schema::hasColumn('siswa_tk', 'tahun_ajaran_id')) {
            DB::table('siswa_tk')->update([
                'tahun_ajaran_id' => 2 // ID tahun ajaran default
            ]);
        }

        // Tambahkan foreign key jika belum ada
        $sm = DB::getDoctrineSchemaManager();
        $existingFks = array_map(fn($fk) => $fk->getName(), $sm->listTableForeignKeys('siswa_tk'));

        if (!in_array('siswa_tk_tahun_ajaran_id_foreign', $existingFks)) {
            Schema::table('siswa_tk', function (Blueprint $table) {
                $table->foreign('tahun_ajaran_id')
                      ->references('id')
                      ->on('tahun_ajaran_tk')
                      ->cascadeOnUpdate()
                      ->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::table('siswa_tk', function (Blueprint $table) {
            if (Schema::hasColumn('siswa_tk', 'tahun_ajaran_id')) {
                $table->dropConstrainedForeignId('tahun_ajaran_id');
            }
        });
    }
};
