<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiMi extends Model
{

    use HasFactory;

    protected $table = 'nilai_mi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'siswa_id', 'guru_id', 'mapel_id', 'kelas_id',
        'tugas', 'uts', 'eas', 'nilai_akhir', 'semester','tahun_ajaran_id'
    ];

    protected $casts = [
        'tugas' => 'array', // biar JSON bisa langsung array
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa_MI::class, 'siswa_id');
    }

    public function mapel()
    {
        return $this->belongsTo(MapelMi::class, 'mapel_id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru_MI::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas_MI::class);
    }

    public function absensis()
    {
        return $this->hasMany(AbsensiMI::class, 'kelas_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaranMI::class, 'tahun_ajaran_id');
    }
}
