<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluasiKinerja extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_kinerja';

    protected $fillable = [
        'user_id',
        'periode',
        'disiplin',
        'tanggung_jawab',
        'kerjasama',
        'kompetensi',
        'kehadiran',
        'nilai_akhir',
        'kategori',
        'deskripsi',
    ];

    /**
     * Relasi ke User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Hitung nilai akhir otomatis dan simpan kategori.
     */
    public function hitungNilaiAkhir()
    {
        $aspek = [
            $this->disiplin,
            $this->tanggung_jawab,
            $this->kerjasama,
            $this->kompetensi,
            $this->kehadiran,
        ];

        // Ambil hanya nilai yang valid (angka dan tidak null)
        $nilai = array_filter($aspek, fn($n) => is_numeric($n));

        if (count($nilai) > 0) {
            $this->nilai_akhir = round(array_sum($nilai) / count($nilai));
        } else {
            $this->nilai_akhir = null;
        }

        // Tentukan kategori
        if ($this->nilai_akhir !== null) {
            if ($this->nilai_akhir >= 90) {
                $this->kategori = 'Sangat Baik';
            } elseif ($this->nilai_akhir >= 75) {
                $this->kategori = 'Baik';
            } elseif ($this->nilai_akhir >= 60) {
                $this->kategori = 'Cukup';
            } else {
                $this->kategori = 'Kurang';
            }
        } else {
            $this->kategori = null;
        }
    }

    /**
     * Auto hitung nilai akhir setiap kali disimpan.
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            $model->hitungNilaiAkhir();
        });
    }
}
