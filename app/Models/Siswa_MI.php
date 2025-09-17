<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa_MI extends Model
{
    use HasFactory;
    protected $table = 'siswas_mi';
    protected $fillable = ['nama', 'nisn', 'tahun', 'no_hp_wali', 'alamat_siswa', 'nama_wali', 'kelas_id'];

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

}

