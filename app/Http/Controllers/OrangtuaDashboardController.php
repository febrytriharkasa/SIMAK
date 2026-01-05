<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa_MI;

class OrangtuaDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // if ($user->role !== 'ortu') {
        //     abort(403, 'Akses ditolak');
        // }

        // Ambil siswa beserta absensi dan nilai
       $siswa = Siswa_MI::with(['kelas', 'tahunAjaran', 'absensis', 'nilais.mapel'])
    ->find($user->siswa_id);


        return view('ortu.index', compact('user', 'siswa'));
    }
}
