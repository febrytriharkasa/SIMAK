<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbsensiTK extends Model
{
    use HasFactory;

    protected $table = 'absensi_tk';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaTk::class, 'siswa_id');
    }

     public function kelas()
    {
        return $this->belongsTo(KelasTk::class, 'kelas_id');
    }
}

