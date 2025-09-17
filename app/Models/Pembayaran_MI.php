<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran_MI extends Model
{
    use HasFactory;
    protected $table = 'pembayarans_mi';
    protected $fillable = ['siswa_id', 'jumlah', 'tanggal', 'status', 'tanggal_bayar'];

    protected $dates = ['tanggal', 'tanggal_bayar'];

    public function siswa()
    {
        return $this->belongsTo(Siswa_MI::class, 'siswa_id');
    }
}
