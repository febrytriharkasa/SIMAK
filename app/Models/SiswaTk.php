<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SiswaTk extends Model
{
    use HasFactory;

    protected $table = 'siswas_tk';

    protected $fillable = [
        'nama',
        'nisn',
        'tahun',
        'tahun_daftar',
        'alamat_siswa',
        'kelas_id',
        'bukti_pembayaran',
        'email',
        'status',
        'foto_siswa',
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

    // Relasi: orang tua
    public function orangtua()
    {
        return $this->belongsTo(User::class, 'orangtua_id');
    }

    // Relasi: kelas
    public function kelas()
    {
        return $this->belongsTo(KelasTk::class, 'kelas_id');
    }

    // Relasi: pembayaran
    public function pembayarans()
    {
        return $this->hasMany(PembayaranTk::class);
    }

    // Relasi: nilai
    public function nilais()
    {
        return $this->hasMany(NilaiTk::class, 'siswa_id');
    }

    // Relasi: absensi
    public function absensis()
    {
        return $this->hasMany(AbsensiTk::class, 'siswa_id');
    }

    // Relasi: tahun ajaran
    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaranTk::class, 'tahun_ajaran_id');
    }

    public function usertk()
    {
        return $this->hasMany(User::class, 'siswa_id');
    }
}
