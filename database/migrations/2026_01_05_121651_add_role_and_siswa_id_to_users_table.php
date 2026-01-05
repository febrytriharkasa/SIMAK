<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tambah kolom role dan siswa_id di users
        if (!Schema::hasColumn('users', 'role') || !Schema::hasColumn('users', 'siswa_id')) {
            Schema::table('users', function (Blueprint $table) {

                if (!Schema::hasColumn('users', 'role')) {
                    $table->string('role')->default('ortu')->after('email');
                }

                if (!Schema::hasColumn('users', 'siswa_id')) {
                    $table->unsignedBigInteger('siswa_id')->nullable()->after('role');

                    // Tambahkan foreign key ke tabel siswa MI
                    $table->foreign('siswa_id')
                          ->references('id')
                          ->on('siswas_mi')
                          ->onDelete('set null'); // kalau siswa dihapus, kolom di users jadi null
                }
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            // Drop foreign key dulu sebelum drop kolom
            if (Schema::hasColumn('users', 'siswa_id')) {
                $table->dropForeign(['siswa_id']);
                $table->dropColumn('siswa_id');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
