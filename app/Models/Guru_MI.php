<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru_MI extends Model
{
    use HasFactory;
    protected $table = 'gurus_mi';
    protected $fillable = ['nama', 'nip', 'mapel', 'no_hp_guru', 'alamat_guru'];
}