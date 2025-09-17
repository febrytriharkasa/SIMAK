<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru_MI extends Model
{
    use HasFactory;

    protected $table = 'gurus_mi';
    protected $fillable = ['nama', 'nip', 'no_hp_guru', 'alamat_guru'];

    public function mapels()
    {
        return $this->belongsToMany(MapelMi::class, 'guru_mi_mapel', 'guru_mi_id', 'mapel_id');
    }
}
