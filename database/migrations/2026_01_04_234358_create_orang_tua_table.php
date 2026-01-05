<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id'); // relasi ke siswa
            $table->string('email')->unique();
            $table->string('password'); // simpan hashed password
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas_mi')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orang_tua');
    }
};
