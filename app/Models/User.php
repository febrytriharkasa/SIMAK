<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Siswa_MI;
use App\Models\SiswaTk;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nip',
        'name',
        'email',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'mata_pelajaran',
        'kelas_diampu',
        'jabatan',
        'tanggal_masuk',
        'pendidikan',
        'status_kepegawaian',
        'role',
        'status',
        'email_verified_at',
        'password',
        'remember_token',
        'foto', 
        'last_password_changed_at',
        'siswa_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relasi: Evaluasi Kinerja
    public function evaluasiKinerja()
    {
        return $this->hasMany(EvaluasiKinerja::class);
    }

    public function siswaMi()
    {
        return $this->belongsTo(Siswa_MI::class, 'siswa_id');
    }

}
