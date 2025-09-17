<?php

namespace App\Observers;

use App\Models\Siswa_MI;
use App\Models\NilaiMi;
use App\Models\Kelas_MI;

class NilaiMiObserver
{
    /**
     * Handle the NilaiMi "saved" event.
     */
    public function saved(NilaiMi $nilai)
    {
        $siswa = $nilai->siswa;
        if (!$siswa || !$siswa->kelas) return;

        $totalMapel = \App\Models\MapelMi::count();
        $jumlahNilai = $siswa->nilais()
            ->where('kelas_id', $siswa->kelas_id)
            ->count();

        if ($jumlahNilai < $totalMapel) return;

        $rataNilai = $siswa->nilais()
            ->where('kelas_id', $siswa->kelas_id)
            ->avg('nilai_akhir');

        if ($rataNilai >= 70) {
            $kelasBerikut = Kelas_MI::where('tingkat', $siswa->kelas->tingkat + 1)->first();
            if ($kelasBerikut) {
                $siswa->update(['kelas_id' => $kelasBerikut->id]);
            }
        }
    }
}

