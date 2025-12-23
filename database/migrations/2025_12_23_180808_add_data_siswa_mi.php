<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->string('nama_ayah')->nullable()->after('nama_wali');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
            $table->text('alamat_orangtua')->nullable()->after('alamat_siswa');
            $table->string('no_hp_orangtua')->nullable()->after('alamat_orangtua');
            $table->string('pekerjaan_ayah')->nullable()->after('no_hp_orangtua');
            $table->string('pekerjaan_ibu')->nullable()->after('pekerjaan_ayah');
            $table->string('pendidikan_ayah')->nullable()->after('pekerjaan_ibu');
            $table->string('pendidikan_ibu')->nullable()->after('pendidikan_ayah');
            $table->decimal('penghasilan_ayah', 15, 2)->nullable()->after('pendidikan_ibu');
            $table->decimal('penghasilan_ibu', 15, 2)->nullable()->after('penghasilan_ayah');
        });
    }

    public function down(): void
    {
        Schema::table('siswas_mi', function (Blueprint $table) {
            $table->dropColumn([
                'nama_ayah', 'nama_ibu', 'alamat_orangtua', 'no_hp_orangtua',
                'pekerjaan_ayah', 'pekerjaan_ibu', 'pendidikan_ayah', 'pendidikan_ibu',
                'penghasilan_ayah', 'penghasilan_ibu'
            ]);
        });
    }
};
