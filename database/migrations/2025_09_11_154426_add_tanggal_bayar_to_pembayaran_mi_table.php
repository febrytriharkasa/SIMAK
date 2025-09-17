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
        Schema::table('pembayarans_mi', function (Blueprint $table) {
            $table->date('tanggal_bayar')->nullable()->after('tanggal');
        });
    }

    public function down()
    {
        Schema::table('pembayarans_mi', function (Blueprint $table) {
            $table->dropColumn('tanggal_bayar');
        });
    }

};
