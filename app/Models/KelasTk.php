<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KelasTk extends Model
{
    use HasFactory;
    protected $table = 'kelas_tk';
    protected $fillable = ['nama_kelas', 'tingkat'];

    public function siswas()
    {
        return $this->hasMany(SiswaTk::class, 'kelas_id');
    }
}
