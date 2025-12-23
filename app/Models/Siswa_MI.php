<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa_MI extends Model
{
    use HasFactory;

    protected $table = 'siswas_mi'; // pastikan ini benar
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

         // kolom tambahan orang tua
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


    public function pembayarans()
    {
        return $this->hasMany(Pembayaran_MI::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas_Mi::class, 'kelas_id');
    }
    
    public function nilais()
    {
        return $this->hasMany(NilaiMi::class, 'siswa_id');
    }

    public function absensis()
    {
        return $this->hasMany(AbsensiMI::class, 'siswa_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaranMI::class, 'tahun_ajaran_id');
    }

}
