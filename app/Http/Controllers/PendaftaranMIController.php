<?php

namespace App\Http\Controllers;

use App\Models\Siswa_MI;
use App\Models\Kelas_MI;
use App\Models\TahunAjaranMI;
use App\Models\Orangtua;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\PendaftaranMIStatusMail;

class PendaftaranMIController extends Controller
{
    // ================= FORM PENDAFTARAN =================
    public function create()
    {
        $kelasList = Kelas_MI::orderBy('tingkat')->get();
        return view('mi.pendaftaran-mi.create', compact('kelasList'));
    }

    // ================= SIMPAN PENDAFTARAN =================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:siswas_mi,email',
            'tahun' => 'required|digits:4',
            'alamat_siswa' => 'required',
            'nama_wali' => 'nullable|string|max:255', // ✅
            
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
            'alamat_orangtua' => 'required',
            'no_hp_orangtua' => 'required',
            'bukti_pembayaran' => 'required|image|max:5120',
            'kk' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            'akte' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
            'foto_siswa' => 'required|image|max:2048',
        ]);

        // Tahun ajaran aktif
        $tahunAjaranAktif = TahunAjaranMI::where('aktif', true)->first();
        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tahun ajaran aktif belum ditentukan.');
        }

        // Kelas 1 default
        $kelas1 = Kelas_MI::where('tingkat', 1)->first();

        // Upload file
        $bukti = $request->file('bukti_pembayaran')->store('bukti-pendaftaran', 'public');
        $kk = $request->file('kk')->store('dokumen/kk', 'public');
        $akte = $request->file('akte')->store('dokumen/akte', 'public');
        $foto = $request->file('foto_siswa')->store('dokumen/foto_siswa', 'public');

        // Simpan siswa
        $siswa = Siswa_MI::create([
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'email' => $request->email,
            'tahun' => $request->tahun,
            'kelas_id' => $kelas1->id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id,
            'alamat_siswa' => $request->alamat_siswa,
            'status' => 'pending',
            'bukti_pembayaran' => $bukti,
            'kk' => $kk,
            'akte' => $akte,
            'foto_siswa' => $foto,
            'nama_wali' => $request->nama_wali ?? null, 
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'alamat_orangtua' => $request->alamat_orangtua,
            'no_hp_orangtua' => $request->no_hp_orangtua,
        ]);

        // Simpan data orang tua (BELUM login)
        Orangtua::create([
            'siswa_id' => $siswa->id,
            'email' => $request->email,
            'status' => 'pending'
        ]);

        return back()->with('success', 'Pendaftaran berhasil. Menunggu persetujuan admin.');
    }

    // ================= ADMIN LIST =================
    public function index()
    {
        $siswas = Siswa_MI::where('status', 'pending')->get();
        return view('admin.pendaftaran-mi-approvel.index', compact('siswas'));
    }

    // ================= APPROVE ADMIN =================
    public function approve($id)
    {
        $siswa = Siswa_MI::findOrFail($id);

        // ==== GENERATE NISN ====
        $prefix = $siswa->tahun . '222';
        $lastNisn = Siswa_MI::where('nisn', 'like', $prefix . '%')
            ->orderBy('nisn', 'desc')
            ->value('nisn');

        $urut = $lastNisn ? ((int) substr($lastNisn, -3) + 1) : 1;
        $nisn = $prefix . str_pad($urut, 3, '0', STR_PAD_LEFT);

        // Update siswa
        $siswa->update([
            'nisn' => $nisn,
            'status' => 'aktif'
        ]);

        // ==== BUAT PASSWORD RANDOM ====
        $passwordPlain = Str::random(8);

        // ==== CEK USER ORTU (ANTI DOUBLE) ====
        $user = User::where('siswa_id', $siswa->id)->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Orang Tua ' . $siswa->nama,
                'email' => $nisn, // LOGIN = NISN
                'password' => Hash::make($passwordPlain),
                'status' => 'approved',
                'siswa_id' => $siswa->id,
            ]);

             $user->assignRole('ortu');
        }

        // Aktifkan data ortu
        Orangtua::where('siswa_id', $siswa->id)
            ->update(['status' => 'approved']);

        // ==== EMAIL LOGIN ====
        Mail::raw(
            "Akun SIMAK Orang Tua Telah Aktif\n\n".
            "Nama Siswa : {$siswa->nama}\n".
            "Username   : {$nisn}\n".
            "Password   : {$passwordPlain}\n\n".
            "Silakan login dan segera ganti password.",
            function ($msg) use ($siswa) {
                $msg->to($siswa->email)
                    ->subject('Akun Orang Tua SIMAK Aktif');
            }
        );

        return back()->with('success', 'Siswa & akun orang tua berhasil diaktifkan.');
    }

    // ================= REJECT =================
    public function reject($id)
    {
        $siswa = Siswa_MI::findOrFail($id);

        Orangtua::where('siswa_id', $siswa->id)->delete();
        User::where('siswa_id', $siswa->id)->delete();

        Mail::to($siswa->email)
            ->send(new PendaftaranMIStatusMail($siswa, 'rejected'));

        $siswa->delete();

        return back()->with('success', 'Pendaftaran ditolak dan data dihapus.');
    }
}
