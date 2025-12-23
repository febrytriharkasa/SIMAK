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
        Schema::table('nilai_tk', function (Blueprint $table) {
            $table->foreign('tahun_ajaran_id')
                ->references('id')
                ->on('tahun_ajaran_tk')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
