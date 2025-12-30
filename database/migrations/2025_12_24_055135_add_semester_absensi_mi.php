<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensi_mi', function (Blueprint $table) {
            $table->enum('semester', ['ganjil', 'genap'])
                  ->after('tanggal')
                  ->default('ganjil'); // default bisa disesuaikan
        });
    }

    public function down(): void
    {
        Schema::table('absensi_mi', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
