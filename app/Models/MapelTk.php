<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapelTk extends Model
{
    use HasFactory;

    protected $table = 'mapel_tk';
    protected $fillable = ['nama_mapel', 'kode_mapel'];

    public function guru()
    {
        return $this->belongsToMany(GuruTk::class, 'guru_tk_mapel', 'mapel_id', 'guru_tk_id');
    }
}

