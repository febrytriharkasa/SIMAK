<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuruTk extends Model
{
    use HasFactory;

    protected $table = 'guru_tk';

    protected $fillable = ['nama', 'nip', 'no_hp_guru', 'alamat_guru'];

    public function mapels()
    {
        return $this->belongsToMany(MapelTk::class, 'guru_tk_mapel', 'guru_tk_id', 'mapel_id');
    }
}
