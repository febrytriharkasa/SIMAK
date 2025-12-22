<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiMI extends Model
{
    use HasFactory;

    protected $table = 'absensi_mi'; // konsisten pakai plural
    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status', // hadir, izin, sakit, alfa
        'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa_MI::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas_MI::class, 'kelas_id');
    }

}
