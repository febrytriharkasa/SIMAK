<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaranMI extends Model
{
    protected $table = 'tahun_ajaran_mi';

    protected $fillable = [
        'nama_tahun',
        'tanggal_mulai',
        'tanggal_selesai',
        'aktif'
    ];

    /** Scope: ambil tahun ajaran aktif */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // App\Models\TahunAjaranMI.php
    public function siswas()
    {
        return $this->hasMany(Siswa_MI::class, 'tahun_ajaran_id');
    }

    public function nilais()
    {
        return $this->hasMany(NilaiMi::class, 'tahun_ajaran_id');
    }

    public function absensis()
    {
        return $this->hasMany(AbsensiMI::class, 'tahun_ajaran_id');
    }

}
