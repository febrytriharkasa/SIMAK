<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaTk extends Model
{
    use HasFactory;

    protected $table = 'siswa_tk';

    protected $fillable = [
        'id_tk',
        'nama',
        'tahun',
        'nama_wali',
        'no_hp_wali',
        'alamat_siswa',
        'kelas_id',
        'bukti_pembayaran',
        'status',
        'email',
        'kk',
        'akte',
        'foto_siswa'
    ];

    public function pembayarans()
    {
        return $this->hasMany(PembayaranTk::class);
    }

    public function kelas()
    {
        return $this->belongsTo(KelasTk::class, 'kelas_id');
    }

    public function nilais()
    {
        return $this->hasMany(NilaiTk::class, 'siswa_id');
    }

    public function absensis()
    {
        return $this->hasMany(AbsensiTK::class, 'siswa_id');
    }
}
