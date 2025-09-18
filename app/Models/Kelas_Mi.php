<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas_Mi extends Model
{
    use HasFactory;
    protected $table = 'kelas_mi';
    protected $fillable = ['nama_kelas', 'tingkat'];

    public function siswas()
    {
        return $this->hasMany(Siswa_MI::class, 'kelas_id');
    }
    
}
