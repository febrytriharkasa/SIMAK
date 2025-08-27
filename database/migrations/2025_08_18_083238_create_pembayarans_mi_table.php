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
        Schema::create('pembayarans_mi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas_mi')->onDelete('cascade');
            $table->decimal('jumlah', 10, 2);
            $table->date('tanggal');
            $table->enum('status', ['lunas', 'belum'])->default('belum'); // kolom status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans_mi');
    }
};
