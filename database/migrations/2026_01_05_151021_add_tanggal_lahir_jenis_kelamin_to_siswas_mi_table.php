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
            // Tambah kolom tanggal_lahir jika belum ada
            if (!Schema::hasColumn('siswas_mi', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')
                      ->nullable()
                      ->comment('Tanggal lahir siswa')
                      ->after('nama');
            }

            // Tambah kolom jenis_kelamin jika belum ada
            if (!Schema::hasColumn('siswas_mi', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L','P'])
                      ->nullable()
                      ->comment('Jenis kelamin siswa')
                      ->after('tanggal_lahir');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            if (Schema::hasColumn('siswas_mi', 'tanggal_lahir')) {
                $table->dropColumn('tanggal_lahir');
            }

            if (Schema::hasColumn('siswas_mi', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
        });
    }
};
