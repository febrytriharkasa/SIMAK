<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('guru_mi_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_mi_id')->constrained('gurus_mi')->onDelete('cascade');
            $table->foreignId('mapel_id')->constrained('mapel_mi')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_mi_mapel');
    }
};
