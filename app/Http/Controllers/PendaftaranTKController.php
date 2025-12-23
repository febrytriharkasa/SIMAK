<?php

namespace App\Http\Controllers;

use App\Models\SiswaTk;
use App\Models\KelasTk;
use App\Models\TahunAjaranTK;
use Illuminate\Http\Request;
use App\Mail\PendaftaranTKStatusMail;
use Illuminate\Support\Facades\Mail;

class PendaftaranTKController extends Controller
{
    // FORM PENDAFTARAN (WALI)
    public function create()
    {
        $kelasList = KelasTk::orderBy('tingkat')->get();
        return view('tk.pendaftaran-tk.create', compact('kelasList'));
    }

    // SIMPAN PENDAFTARAN
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
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'alamat_orangtua' => 'required',
            'no_hp_orangtua' => 'required',
            'pekerjaan_ayah' => 'nullable',
            'pekerjaan_ibu' => 'nullable',
            'pendidikan_ayah' => 'nullable',
            'pendidikan_ibu' => 'nullable',
            'penghasilan_ayah' => 'nullable|numeric',
            'penghasilan_ibu' => 'nullable|numeric',
            'bukti_pembayaran' => 'required|image|max:5120',
            'kk' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            'akte' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_siswa' => 'required|image|max:2048',
        ]);

        $tahunAjaranAktif = TahunAjaranTK::where('aktif', true)->first();
        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tahun ajaran aktif belum ditentukan oleh admin.');
        }

        $kelas1 = KelasTk::where('tingkat', 1)->first();
        if (!$kelas1) {
            return back()->with('error', 'Kelas 1 belum tersedia.');
        }

        $buktiPembayaran = $request->file('bukti_pembayaran')->store('bukti-pendaftaran', 'public');
        $kk = $request->file('kk')->store('dokumen/kk', 'public');
        $akte = $request->file('akte')->store('dokumen/akte', 'public');
        $foto3x4 = $request->file('foto_siswa')->store('dokumen/foto_siswa', 'public');

        SiswaTk::create([
            'nama'             => $request->nama,
            'email'            => $request->email,
            'tahun'            => $request->tahun,
            'nama_wali'        => $request->nama_wali,
            'no_hp_wali'       => $request->no_hp_wali,
            'alamat_siswa'     => $request->alamat_siswa,
            'kelas_id'         => $kelas1->id,
            'tahun_ajaran_id'  => $tahunAjaranAktif->id,
            'bukti_pembayaran' => $buktiPembayaran,
            'kk'               => $kk,
            'akte'             => $akte,
            'foto_siswa'       => $foto3x4,
            'status'           => 'pending',

            // Tambahan kolom orang tua
            'nama_ayah'        => $request->nama_ayah,
            'nama_ibu'         => $request->nama_ibu,
            'alamat_orangtua'  => $request->alamat_orangtua,
            'no_hp_orangtua'   => $request->no_hp_orangtua,
            'pekerjaan_ayah'   => $request->pekerjaan_ayah,
            'pekerjaan_ibu'    => $request->pekerjaan_ibu,
            'pendidikan_ayah'  => $request->pendidikan_ayah,
            'pendidikan_ibu'   => $request->pendidikan_ibu,
            'penghasilan_ayah' => $request->penghasilan_ayah,
            'penghasilan_ibu'  => $request->penghasilan_ibu,
        ]);

        return back()->with('success', 'Pendaftaran berhasil. Menunggu verifikasi admin.');
    }



    // ADMIN: LIST PENDAFTARAN
    public function index()
    {
        $siswas = SiswaTk::where('status', 'pending')->get();
        $kelasList = KelasTk::orderBy('tingkat')->get();

        return view('admin.pendaftaran-tk-approvel.index', compact('siswas', 'kelasList'));
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

        Mail::to($siswa->email)->send(new PendaftaranTKStatusMail($siswa, 'approved'));

        return back()->with('success', 'Siswa berhasil diaktifkan. No Induk: ' . $nisnBaru);
    }



    public function reject($id)
    {
        $siswa = SiswaTk::findOrFail($id);

        // hapus bukti pembayaran jika ada
        if ($siswa->bukti_pembayaran && file_exists(storage_path('app/public/storage/bukti-pendaftaran/' . $siswa->bukti_pembayaran))) {
            unlink(storage_path('app/public/storage/bukti-pendaftaran/' . $siswa->bukti_pembayaran));
        }

        Mail::to($siswa->email)->send(new PendaftaranTKStatusMail($siswa, 'rejected'));
        // hapus data siswa
        $siswa->delete();

        return back()->with('success', 'Pendaftaran siswa ditolak dan data dihapus.');
    }
}
