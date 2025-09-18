<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NilaiTk extends Model
{

    use HasFactory;

    protected $table = 'nilai_tk';
    protected $primaryKey = 'id';
    protected $fillable = [
        'siswa_id', 'guru_id', 'mapel_id', 'kelas_id',
        'tugas', 'uts', 'eas', 'nilai_akhir'
    ];

    protected $casts = [
        'tugas' => 'array', // biar JSON bisa langsung array
    ];

    public function siswa()
    {
        return $this->belongsTo(SiswaTk::class, 'siswa_id');
    }

    public function mapel()
    {
        return $this->belongsTo(MapelTk::class, 'mapel_id');
    }

    public function guru()
    {
        return $this->belongsTo(GuruTk::class, 'guru_id');
    }

    public function kelas()
    {
        return $this->belongsTo(KelasTk::class);
    }
}
