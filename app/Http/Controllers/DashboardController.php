<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa_MI;
use App\Models\Guru_MI;
use App\Models\Pembayaran_MI;
use App\Models\SiswaTk;
use App\Models\GuruTk;
use App\Models\PembayaranTk;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun; // ambil filter tahun

        // ===================== Statistik MI =====================
        $queryPembayaranMi = Pembayaran_MI::where('status', 'lunas');
        if ($tahun) {
            $queryPembayaranMi->whereYear('tanggal', $tahun);
        }

        $totalPembayaranMi = $queryPembayaranMi->sum('jumlah');
        $jumlahTransaksiMi = $queryPembayaranMi->count();

        // Per bulan
        $pembayaranPerBulanMi = [];
        $transaksiPerBulanMi = [];
        for ($i = 1; $i <= 12; $i++) {
            $pembayaranPerBulanMi[] = (clone $queryPembayaranMi)
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');

            $transaksiPerBulanMi[] = (clone $queryPembayaranMi)
                ->whereMonth('tanggal', $i)
                ->count();
        }

        $jumlahSiswaMi = $tahun 
            ? Siswa_MI::where('tahun', $tahun)->count()
            : Siswa_MI::count();

        $jumlahGuruMi = Guru_MI::count();

        $jumlahSiswaPerTahunMi = Siswa_MI::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->pluck('total', 'tahun')
            ->toArray();

        $jumlahGuruPerMapelMi = DB::table('guru_mi_mapel')
            ->join('mapel_mi', 'guru_mi_mapel.mapel_id', '=', 'mapel_mi.id')
            ->select('mapel_mi.nama_mapel as mapel', DB::raw('count(guru_mi_mapel.guru_mi_id) as total'))
            ->groupBy('mapel_mi.nama_mapel')
            ->pluck('total', 'mapel')
            ->toArray();

        // ===================== Statistik TK =====================
        $queryPembayaranTk = PembayaranTk::where('status', 'lunas');
        if ($tahun) {
            $queryPembayaranTk->whereYear('tanggal', $tahun);
        }

        $totalPembayaranTk = $queryPembayaranTk->sum('jumlah');
        $jumlahTransaksiTk = $queryPembayaranTk->count();

        $pembayaranPerBulanTk = [];
        $transaksiPerBulanTk = [];
        for ($i = 1; $i <= 12; $i++) {
            $pembayaranPerBulanTk[] = (clone $queryPembayaranTk)
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');

            $transaksiPerBulanTk[] = (clone $queryPembayaranTk)
                ->whereMonth('tanggal', $i)
                ->count();
        }

        $jumlahSiswaTk = $tahun 
            ? SiswaTk::where('tahun', $tahun)->count()
            : SiswaTk::count();

        $jumlahGuruTk = GuruTk::count();

        $jumlahSiswaPerTahunTk = SiswaTk::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->pluck('total', 'tahun')
            ->toArray();

         $jumlahGuruPerMapelTk = DB::table('guru_tk_mapel')
            ->join('mapel_tk', 'guru_tk_mapel.mapel_id', '=', 'mapel_tk.id')
            ->select('mapel_tk.nama_mapel as mapel', DB::raw('count(guru_tk_mapel.guru_tk_id) as total'))
            ->groupBy('mapel_tk.nama_mapel')
            ->pluck('total', 'mapel')
            ->toArray();

        // ===================== RETURN =====================
        return view('dashboard', compact(
            'tahun',
            // MI
            'jumlahSiswaMi', 'jumlahGuruMi', 'totalPembayaranMi', 'jumlahTransaksiMi',
            'pembayaranPerBulanMi', 'transaksiPerBulanMi', 'jumlahSiswaPerTahunMi', 'jumlahGuruPerMapelMi',
            // TK
            'jumlahSiswaTk', 'jumlahGuruTk', 'totalPembayaranTk', 'jumlahTransaksiTk',
            'pembayaranPerBulanTk', 'transaksiPerBulanTk', 'jumlahSiswaPerTahunTk' , 'jumlahGuruPerMapelTk'
        ));
    }

}
