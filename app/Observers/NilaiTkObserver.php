<?php

namespace App\Observers;

use App\Models\NilaiTk;
use App\Models\KelasTk;
use App\Models\MapelTk;

class NilaiTkObserver
{
    /**
     * Handle the NilaiTk "saved" event.
     */
    public function saved(NilaiTk $nilai)
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
         * 2. Pastikan semua mapel TK sudah ada
         * ======================================================
         */
        $totalMapel = MapelTk::count();

        if ($nilaiTahunan->count() < $totalMapel) {
            return;
        }

        /**
         * ======================================================
         * 3. Pastikan setiap mapel punya GANJIL + GENAP
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
                return;
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

        // ambang kelulusan TK (bisa kamu ubah)
        if ($rataTahunan < 70) {
            return;
        }

        /**
         * ======================================================
         * 5. Naik kelas (SATU KALI & AMAN)
         * ======================================================
         */
        $kelasBerikut = KelasTk::where(
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
