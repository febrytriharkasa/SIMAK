<?php
namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Siswa_MI;
use App\Models\Guru_MI;
use App\Models\Pembayaran_MI;
use App\Models\SiswaTk;
use App\Models\GuruTk;
use App\Models\PembayaranTk;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('dashboard', function ($view) {
            $view->with([
                'jumlahSiswaMi' => Siswa_MI::count(),
                'jumlahGuruMi' => Guru_MI::count(),
                'totalPembayaranMi' => Pembayaran_MI::where('status','lunas')->sum('jumlah'),
                'jumlahTransaksiMi' => Pembayaran_MI::where('status','lunas')->count(),
                'jumlahSiswaTk' => SiswaTk::count(),
                'jumlahGuruTk' => GuruTk::count(),
                'totalPembayaranTk' => PembayaranTk::where('status','lunas')->sum('jumlah'),
                'jumlahTransaksiTk' => PembayaranTk::where('status','lunas')->count(),
            ]);
        });
    }
}
