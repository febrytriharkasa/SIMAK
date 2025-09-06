<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GuruTk extends Model
{
    use HasFactory;

    protected $table = 'guru_tk';

    protected $fillable = [
        'nama',
        'nip',
        'mapel',
        'no_hp_guru',
        'alamat_guru',
    ];
}
