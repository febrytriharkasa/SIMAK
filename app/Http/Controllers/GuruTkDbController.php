<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiswaTk;
use App\Models\GuruTk;
use App\Models\PembayaranTk;
use Illuminate\Support\Facades\DB;

class GuruTkDbController extends Controller
{
    public function index()
    {
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
        return view('dashboard.dashboard_tk', compact(
            'jumlahSiswaTk','jumlahGuruTk','totalPembayaranTk','jumlahTransaksiTk',
            'pembayaranPerBulanTk','transaksiPerBulanTk',
            'jumlahSiswaPerTahunTk','jumlahGuruPerMapelTk'
        ));
    }
}
