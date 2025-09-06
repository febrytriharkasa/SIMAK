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
        Schema::create('guru_tk', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('nip', 50)->unique();
            $table->string('mapel', 100);
            $table->string('no_hp_guru', 20)->nullable();
            $table->text('alamat_guru')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_tk');
    }
};
