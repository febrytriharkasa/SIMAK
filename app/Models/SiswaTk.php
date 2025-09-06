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
    ];

    public function pembayarans()
    {
        return $this->hasMany(PembayaranTk::class);
    }
}
