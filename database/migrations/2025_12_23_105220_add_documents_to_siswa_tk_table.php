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
        Schema::table('siswa_tk', function (Blueprint $table) {
            $table->string('kk')->nullable()->after('bukti_pembayaran');
            $table->string('akte')->nullable()->after('kk');
            $table->string('foto_siswa')->nullable()->after('akte');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswa_tk', function (Blueprint $table) {
            $table->dropColumn(['kk', 'akte', 'foto_siswa']);
        });
    }
};
