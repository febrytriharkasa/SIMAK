<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('nilai_mi', function (Blueprint $table) {
            $table->enum('semester', ['ganjil', 'genap'])
                  ->after('kelas_id');
        });
    }

    public function down()
    {
        Schema::table('nilai_mi', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
