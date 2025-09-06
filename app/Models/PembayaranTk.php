<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranTk extends Model
{
    use HasFactory;
    protected $table = 'pembayaran_tk';
    protected $fillable = ['siswa_id', 'jumlah', 'tanggal', 'status'];

    public function siswa()
    {
        return $this->belongsTo(SiswaTk::class, 'siswa_id');
    }
}
