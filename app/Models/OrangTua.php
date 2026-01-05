<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\SiswaMi;

class OrangTua extends Authenticatable
{
    use Notifiable;

    protected $table = 'orang_tua'; // nama tabel

    protected $fillable = [
        'siswa_id',
        'email',
        'password',
        'is_approved', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Relasi: OrangTua punya 1 Siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa_Mi::class, 'siswa_id');
    }
}
