<?php

namespace App\Http\Controllers;

use App\Models\Siswa_MI;
use App\Models\Kelas_MI;
use Illuminate\Http\Request;
use App\Mail\PendaftaranMIStatusMail;
use Illuminate\Support\Facades\Mail;

class PendaftaranMIController extends Controller
{
    // FORM PENDAFTARAN (WALI)
    public function create()
    {
        $kelasList = Kelas_MI::orderBy('tingkat')->get();
        return view('mi.pendaftaran-mi.create', compact('kelasList'));
    }

    // SIMPAN PENDAFTARAN
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:siswas_mi,email',
            'tahun' => 'required|digits:4',
            'nama_wali' => 'required',
            'no_hp_wali' => 'required',
            'alamat_siswa' => 'required',
            'bukti_pembayaran' => 'required|image|max:5120', // 5MB
            'kk' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            'akte' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_siswa' => 'required|image|max:2048', // 2MB
        ]);

        // ambil kelas 1 otomatis
        $kelas1 = Kelas_MI::where('tingkat', 1)->first();
        if (!$kelas1) {
            return back()->with('error', 'Kelas 1 belum tersedia.');
        }

        // simpan file
        $buktiPembayaran = $request->file('bukti_pembayaran')->store('bukti-pendaftaran', 'public');
        $kk = $request->file('kk')->store('dokumen/kk', 'public');
        $akte = $request->file('akte')->store('dokumen/akte', 'public');
        $foto3x4 = $request->file('foto_siswa')->store('dokumen/foto_siswa', 'public');

        // simpan data siswa
        Siswa_MI::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'tahun' => $request->tahun,
            'nama_wali' => $request->nama_wali,
            'no_hp_wali' => $request->no_hp_wali,
            'alamat_siswa' => $request->alamat_siswa,
            'kelas_id' => $kelas1->id,
            'bukti_pembayaran' => $buktiPembayaran,
            'kk' => $kk,
            'akte' => $akte,
            'foto_siswa' => $foto3x4,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pendaftaran berhasil. Menunggu verifikasi admin.');
    }



    // ADMIN: LIST PENDAFTARAN
    public function index()
    {
        $siswas = Siswa_MI::where('status', 'pending')->get();
        $kelasList = Kelas_MI::orderBy('tingkat')->get();

        return view('admin.pendaftaran-mi-approvel.index', compact('siswas','kelasList'));
    }

    public function approve($id)
    {
        $siswa = Siswa_MI::findOrFail($id);

        // ambil tahun masuk (contoh: 2025)
        $tahun = $siswa->tahun;

        // kode MI      
        $kodeSekolah = '222';

        // prefix NIS: 2025222
        $prefix = $tahun . $kodeSekolah;

        // ambil NIS terakhir
        $lastNisn = Siswa_MI::where('nisn', 'like', $prefix.'%')
            ->orderBy('nisn', 'desc')
            ->value('nisn');

        $urut = $lastNisn ? ((int) substr($lastNisn, -3) + 1) : 1;

        $nisBaru = $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);

        // ambil kelas 1 otomatis
        $kelas1 = Kelas_MI::where('tingkat', 1)->first();

        if (!$kelas1) {
            return back()->with('error', 'Kelas 1 belum tersedia.');
        }

        $siswa->update([
            'nisn' => $nisBaru,
            'kelas_id' => $kelas1->id,
            'status' => 'aktif'
        ]);

        Mail::to($siswa->email)->send(new PendaftaranMIStatusMail($siswa, 'approved'));

        return back()->with('success', 'Siswa berhasil diaktifkan. No Induk: '.$nisBaru);
    }

    
    public function reject($id)
    {
        $siswa = Siswa_MI::findOrFail($id);

        // hapus bukti pembayaran jika ada
        if ($siswa->bukti_pembayaran && file_exists(storage_path('app/public/storage/bukti-pendaftaran/'.$siswa->bukti_pembayaran))) {
            unlink(storage_path('app/public/storage/bukti-pendaftaran'.$siswa->bukti_pembayaran));
        }

        Mail::to($siswa->email)->send(new PendaftaranMIStatusMail($siswa, 'rejected'));

        $siswa->delete();

        return back()->with('success', 'Pendaftaran siswa telah ditolak dan data dihapus.');
    }


}

