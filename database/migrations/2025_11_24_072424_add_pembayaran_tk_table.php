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
        Schema::create('pembayarans_tk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa_tk')->onDelete('cascade');
            $table->string('jenis_tagihan'); // kolom jenis tagihan
            $table->decimal('jumlah', 10, 2);
            $table->date('tanggal');
            $table->dropColumn('tanggal_bayar');
            $table->enum('status', ['lunas', 'belum'])->default('belum'); // kolom status
            $table->timestamps();
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
