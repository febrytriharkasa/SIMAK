<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran_MI;
use App\Models\Siswa_MI;
use App\Models\Kelas_Mi;
use Illuminate\Http\Request;

class LaporanPembayaranMIController extends Controller
{
    /**
     * Tampilkan laporan pembayaran MI
     */
    public function index(Request $request)
    {
        // Ambil filter
        $kelas_id = $request->kelas_id;
        $status = $request->status;
        $jenis = $request->jenis_tagihan;
        $bulan = $request->bulan;

        // Ambil daftar kelas (untuk dropdown dan urutan tampil)
        $kelasList = Kelas_Mi::orderBy('nama_kelas', 'asc')->get();

        $data = [];

        // Kalau pilih kelas tertentu → hanya tampilkan kelas itu
        $kelasQuery = $kelas_id
            ? $kelasList->where('id', $kelas_id)
            : $kelasList;

        foreach ($kelasQuery as $kelas) {
            // Ambil semua siswa dalam kelas ini
            $siswaList = Siswa_MI::where('kelas_id', $kelas->id)->get();

            foreach ($siswaList as $siswa) {
                // Ambil semua pembayaran siswa berdasarkan filter
                $pembayaranList = Pembayaran_MI::where('siswa_id', $siswa->id)
                    ->when($status, fn($q) => $q->where('status', $status))
                    ->when($jenis, fn($q) => $q->where('jenis_tagihan', 'like', "%{$jenis}%"))
                    ->when($bulan, fn($q) => $q->whereMonth('tanggal', $bulan))
                    ->orderBy('tanggal', 'asc')
                    ->get();

                if ($pembayaranList->isNotEmpty()) {
                    $data[$kelas->nama_kelas][$siswa->nama] = $pembayaranList;
                }
            }
        }

        return view('mi.laporan-pembayaran-mi.index', [
            'data' => $data,
            'bulan' => $bulan,
            'status' => $status,
            'jenis_tagihan' => $jenis,
            'kelas_id' => $kelas_id,
            'kelasList' => $kelasList,
        ]);
    }
}
