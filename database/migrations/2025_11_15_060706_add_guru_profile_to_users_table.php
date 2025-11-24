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
        Schema::table('users', function (Blueprint $table) {

            // Cek dan tambahkan kolom hanya jika belum ada
            if (!Schema::hasColumn('users', 'tempat_lahir')) {
                $table->string('tempat_lahir')->nullable()->after('nip');
            }
            if (!Schema::hasColumn('users', 'tanggal_lahir')) {
                $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            }
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['Laki-laki','Perempuan'])->nullable()->after('tanggal_lahir');
            }
            if (!Schema::hasColumn('users', 'agama')) {
                $table->string('agama')->nullable()->after('jenis_kelamin');
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('agama');
            }
            if (!Schema::hasColumn('users', 'no_hp')) {
                $table->string('no_hp')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'mata_pelajaran')) {
                $table->string('mata_pelajaran')->nullable()->after('no_hp');
            }
            if (!Schema::hasColumn('users', 'kelas_diampu')) {
                $table->string('kelas_diampu')->nullable()->after('mata_pelajaran');
            }
            if (!Schema::hasColumn('users', 'jabatan')) {
                $table->string('jabatan')->nullable()->after('kelas_diampu');
            }
            if (!Schema::hasColumn('users', 'tanggal_masuk')) {
                $table->date('tanggal_masuk')->nullable()->after('jabatan');
            }
            if (!Schema::hasColumn('users', 'pendidikan')) {
                $table->string('pendidikan')->nullable()->after('tanggal_masuk');
            }
            if (!Schema::hasColumn('users', 'status_kepegawaian')) {
                $table->string('status_kepegawaian')->nullable()->after('pendidikan');
            }
            if (!Schema::hasColumn('users', 'foto')) {
                $table->string('foto')->nullable()->after('status_kepegawaian');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $columns = [
                'tempat_lahir','tanggal_lahir','jenis_kelamin','agama','alamat',
                'no_hp','mata_pelajaran','kelas_diampu','jabatan','tanggal_masuk',
                'pendidikan','status_kepegawaian','foto'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};