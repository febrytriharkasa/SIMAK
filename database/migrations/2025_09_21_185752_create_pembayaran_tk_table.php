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
        Schema::create('pembayaran_tk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa_tk')->onDelete('cascade');
            $table->string('jenis_tagihan');
            $table->decimal('jumlah', 10, 2);
            $table->date('tanggal');
            $table->date('tanggal_bayar')->nullable();
            $table->enum('status', ['lunas', 'belum'])->default('belum'); // kolom status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_tk');
    }
};
