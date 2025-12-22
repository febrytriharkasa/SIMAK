<?php

namespace App\Http\Controllers;

use App\Models\SiswaTk;
use App\Models\KelasTk;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class PendaftaranTKController extends Controller
{
    // FORM PENDAFTARAN (WALI)
    public function create()
    {
        $kelasList = KelasTk::orderBy('tingkat')->get();
        return view('tk.pendaftaran-tk.create', compact('kelasList'));
    }

    // SIMPAN PENDAFTARAN
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tahun' => 'required|digits:4',
            'nama_wali' => 'required',
            'no_hp_wali' => 'required',
            'alamat_siswa' => 'required',
            'bukti_pembayaran' => 'required|image|max:5120', // 5MB
        ]);

        // ambil kelas 1 otomatis
        $kelas1 = KelasTk::where('tingkat', 1)->first();

        if (!$kelas1) {
            return back()->with('error', 'Kelas 1 belum tersedia.');
        }

        $file = $request->file('bukti_pembayaran')
            ->store('bukti-pendaftaran', 'public');

        SiswaTk::create([
            'nama' => $request->nama,
            'tahun' => $request->tahun,
            'nama_wali' => $request->nama_wali,
            'no_hp_wali' => $request->no_hp_wali,
            'alamat_siswa' => $request->alamat_siswa,
            'kelas_id' => $kelas1->id, // ✅ OTOMATIS KELAS 1
            'bukti_pembayaran' => $file,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pendaftaran berhasil. Menunggu verifikasi admin.');
    }


    // ADMIN: LIST PENDAFTARAN
    public function index()
    {
        $siswas = SiswaTk::where('status', 'pending')->get();
        $kelasList = KelasTk::orderBy('tingkat')->get();

        return view('admin.pendaftaran-tk-approvel.index', compact('siswas','kelasList'));
    }

   public function approve($id)
    {
        $siswa = SiswaTk::findOrFail($id);

        // Ambil kelas otomatis (misal kelas 1)
        $kelas1 = KelasTk::where('tingkat', 1)->first();

        // Generate NISN (contoh 2025 + kode sekolah + urutan)
        $tahun = $siswa->tahun;
        $kodeSekolah = '111'; // misal kode MI/TK
        $prefix = $tahun . $kodeSekolah;

        $lastNisn = SiswaTk::where('id_tk', 'like', $prefix . '%')
                    ->orderBy('id_tk', 'desc')
                    ->value('id_tk');

        $urut = $lastNisn ? ((int)substr($lastNisn, -3) + 1) : 1;

        $nisnBaru = $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);

        // Update semua data sekaligus termasuk status aktif
        $siswa->update([
            'id_tk' => $nisnBaru,
            'kelas_id' => $kelas1->id,
            'status' => 'aktif', // ✅ ini penting
        ]);

        return back()->with('success', 'Siswa berhasil diaktifkan. No Induk: ' . $nisnBaru);
    }



    public function reject($id)
    {
        $siswa = SiswaTk::findOrFail($id);

        // hapus bukti pembayaran jika ada
        if ($siswa->bukti_pembayaran && file_exists(storage_path('app/public/storage/bukti-pendaftaran/'.$siswa->bukti_pembayaran))) {
            unlink(storage_path('app/public/storage/bukti-pendaftaran/'.$siswa->bukti_pembayaran));
        }

        // hapus data siswa
        $siswa->delete();

        return back()->with('success', 'Pendaftaran siswa ditolak dan data dihapus.');
    }


}

