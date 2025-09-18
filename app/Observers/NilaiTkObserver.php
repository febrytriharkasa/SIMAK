<?php

namespace App\Observers;

use App\Models\SiswaTk;
use App\Models\NilaiTk;
use App\Models\KelasTk;

class NilaiTkObserver
{
    /**
     * Handle the NilaiMi "saved" event.
     */
    public function saved(NilaiTK $nilai)
    {
        $siswa = $nilai->siswa;
        if (!$siswa || !$siswa->kelas) return;

        $totalMapel = \App\Models\MapelTk::count();
        $jumlahNilai = $siswa->nilais()
            ->where('kelas_id', $siswa->kelas_id)
            ->count();

        if ($jumlahNilai < $totalMapel) return;

        $rataNilai = $siswa->nilais()
            ->where('kelas_id', $siswa->kelas_id)
            ->avg('nilai_akhir');

        if ($rataNilai >= 70) {
            $kelasBerikut = KelasTk::where('tingkat', $siswa->kelas->tingkat + 1)->first();
            if ($kelasBerikut) {
                $siswa->update(['kelas_id' => $kelasBerikut->id]);
            }
        }
    }
}

