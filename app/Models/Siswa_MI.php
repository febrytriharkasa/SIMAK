<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Untuk relasi orang tua

class Siswa_MI extends Model
{
    use HasFactory;

    protected $table = 'siswas_mi'; // pastikan nama tabel sesuai DB

    protected $fillable = [
        'nama',
        'nisn',
        'tahun',
        'tahun_daftar',
        'no_hp_wali',
        'alamat_siswa',
        'nama_wali',
        'kelas_id',
        'bukti_pembayaran',
        'email',
        'status',
        'kk',
        'akte',
        'foto_siswa',
        'tahun_ajaran_id',
        'orangtua_id', // foreign key ke User
        'nama_ayah',
        'nama_ibu',
        'alamat_orangtua',
        'no_hp_orangtua',
        'pekerjaan_ayah',
        'pekerjaan_ibu',
        'pendidikan_ayah',
        'pendidikan_ibu',
        'penghasilan_ayah',
        'penghasilan_ibu',
    ];

    // Relasi: kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas_Mi::class, 'kelas_id');
    }

    // Relasi: pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran_MI::class);
    }

    // Relasi: nilai
    public function nilais()
    {
        return $this->hasMany(NilaiMi::class, 'siswa_id');
    }

    // Relasi: absensi
    public function absensis()
    {
        return $this->hasMany(AbsensiMI::class, 'siswa_id');
    }

    // Relasi: tahun ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaranMI::class, 'tahun_ajaran_id');
    }

}
