<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelMi extends Model
{
    use HasFactory;

    protected $table = 'mapel_mi';
    protected $fillable = ['nama_mapel', 'kode_mapel'];

    public function guru()
    {
        return $this->belongsToMany(Guru_MI::class, 'guru_mi_mapel', 'mapel_id', 'guru_mi_id');
    }
}

