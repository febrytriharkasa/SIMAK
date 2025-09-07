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
    public function index()
    {
        // ===================== Statistik MI =====================
        $jumlahSiswaMi = Siswa_MI::count();
        $jumlahGuruMi = Guru_MI::count();
        $totalPembayaranMi = Pembayaran_MI::where('status','lunas')->sum('jumlah');
        $jumlahTransaksiMi = Pembayaran_MI::where('status','lunas')->count();

        // Chart pembayaran & transaksi per bulan MI
        $pembayaranPerBulanMi = [];
        $transaksiPerBulanMi = [];
        for($i=1; $i<=12; $i++){
            $pembayaranPerBulanMi[] = Pembayaran_MI::where('status','lunas')
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');

            $transaksiPerBulanMi[] = Pembayaran_MI::where('status','lunas')
                ->whereMonth('tanggal', $i)
                ->count();
        }

        // Chart jumlah siswa per tahun MI
        $jumlahSiswaPerTahunMi = Siswa_MI::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->pluck('total','tahun')
            ->toArray();

        // Chart jumlah guru per mapel MI
        $jumlahGuruPerMapelMi = Guru_MI::select('mapel', DB::raw('count(*) as total'))
            ->groupBy('mapel')
            ->pluck('total','mapel')
            ->toArray();

        // ===================== Statistik TK =====================
        $jumlahSiswaTk = SiswaTk::count();
        $jumlahGuruTk = GuruTk::count();
        $totalPembayaranTk = PembayaranTk::where('status','lunas')->sum('jumlah');
        $jumlahTransaksiTk = PembayaranTk::where('status','lunas')->count();

        // Chart pembayaran & transaksi per bulan TK
        $pembayaranPerBulanTk = [];
        $transaksiPerBulanTk = [];
        for($i=1; $i<=12; $i++){
            $pembayaranPerBulanTk[] = PembayaranTk::where('status','lunas')
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');

            $transaksiPerBulanTk[] = PembayaranTk::where('status','lunas')
                ->whereMonth('tanggal', $i)
                ->count();
        }

        // Chart jumlah siswa per tahun TK
        $jumlahSiswaPerTahunTk = SiswaTk::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->pluck('total','tahun')
            ->toArray();

        // Chart jumlah guru per mapel TK
        $jumlahGuruPerMapelTk = GuruTk::select('mapel', DB::raw('count(*) as total'))
            ->groupBy('mapel')
            ->pluck('total','mapel')
            ->toArray();

        // ===================== RETURN =====================
        return view('dashboard', compact(
            // MI
            'jumlahSiswaMi','jumlahGuruMi','totalPembayaranMi','jumlahTransaksiMi',
            'pembayaranPerBulanMi','transaksiPerBulanMi','jumlahSiswaPerTahunMi','jumlahGuruPerMapelMi',

            // TK
            'jumlahSiswaTk','jumlahGuruTk','totalPembayaranTk','jumlahTransaksiTk',
            'pembayaranPerBulanTk','transaksiPerBulanTk','jumlahSiswaPerTahunTk','jumlahGuruPerMapelTk'
        ));
    }
}
