<?php

namespace App\Observers;

use App\Models\NilaiMi;
use App\Models\Kelas_MI;
use App\Models\MapelMi;

class NilaiMiObserver
{
    /**
     * Handle the NilaiMi "saved" event.
     */
    public function saved(NilaiMi $nilai)
    {
        $siswa = $nilai->siswa;

        // validasi dasar
        if (!$siswa || !$siswa->kelas) {
            return;
        }

        $kelasId = $siswa->kelas_id;

        /**
         * ======================================================
         * 1. Ambil seluruh nilai GANJIL + GENAP di kelas ini
         * ======================================================
         */
        $nilaiTahunan = $siswa->nilais()
            ->where('kelas_id', $kelasId)
            ->whereIn('semester', ['ganjil', 'genap'])
            ->get()
            ->groupBy('mapel_id');

        /**
         * ======================================================
         * 2. Pastikan semua mapel punya nilai
         * ======================================================
         */
        $totalMapel = MapelMi::count();

        if ($nilaiTahunan->count() < $totalMapel) {
            return; // belum semua mapel dinilai
        }

        /**
         * ======================================================
         * 3. Pastikan tiap mapel punya GANJIL + GENAP
         * ======================================================
         */
        foreach ($nilaiTahunan as $mapelId => $nilaiMapel) {
            $semesterLengkap = $nilaiMapel
                ->pluck('semester')
                ->unique()
                ->sort()
                ->values()
                ->toArray();

            if ($semesterLengkap !== ['ganjil', 'genap']) {
                return; // ada mapel yang belum lengkap 1 tahun
            }
        }

        /**
         * ======================================================
         * 4. Hitung rata-rata nilai TAHUNAN
         * ======================================================
         */
        $rataTahunan = $nilaiTahunan
            ->flatten()
            ->avg('nilai_akhir');

        // KKM
        if ($rataTahunan < 70) {
            return;
        }

        /**
         * ======================================================
         * 5. Naik kelas (SATU KALI SAJA)
         * ======================================================
         */
        $kelasBerikut = Kelas_MI::where(
            'tingkat',
            $siswa->kelas->tingkat + 1
        )->first();

        if ($kelasBerikut) {
            $siswa->update([
                'kelas_id' => $kelasBerikut->id
            ]);
        }
    }
}
