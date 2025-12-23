<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->unsignedBigInteger('tahun_ajaran_id')
                ->after('tahun')
                ->nullable(); // PENTING
        });

        // ISI DATA LAMA
        DB::table('siswas_mi')->update([
            'tahun_ajaran_id' => 2 // ← ID tahun ajaran yang kamu mau
        ]);

        // BARU TAMBAHKAN FOREIGN KEY
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->foreign('tahun_ajaran_id')
                ->references('id')
                ->on('tahun_ajaran')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }
};
