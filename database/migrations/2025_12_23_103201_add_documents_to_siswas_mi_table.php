<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->string('kk')->nullable()->after('bukti_pembayaran');
            $table->string('akte')->nullable()->after('kk');
            $table->string('foto_siswa')->nullable()->after('akte');
        });
    }

    public function down(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->dropColumn(['kk', 'akte', 'foto_siswa']);
        });
    }
};
