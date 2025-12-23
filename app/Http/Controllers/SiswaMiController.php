<?php

namespace App\Http\Controllers;

use App\Models\Siswa_MI;
use App\Models\Kelas_Mi;
use App\Models\TahunAjaranMI;
use Illuminate\Http\Request;

class SiswaMiController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa_MI::with(['kelas', 'tahunAjaran'])
            ->orderBy('nisn', 'asc'); // urutkan berdasarkan NISN

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        $siswa = $query->paginate(10);
        return view('mi.siswa-mi.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas_Mi::orderBy('tingkat')->get();
        return view('mi.siswa-mi.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:siswas_mi,email',
            'nisn' => 'required|string|unique:siswas_mi,nisn',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'no_hp_wali' => 'required|string|max:20',
            'alamat_siswa' => 'required|string|max:255',
            'nama_wali' => 'required|string|max:255',
            'kelas_id' => 'nullable|exists:kelas_mi,id',
        ]);

        // 🔥 AMBIL TAHUN AJARAN AKTIF
        $tahunAjaranAktif = TahunAjaranMI::where('aktif', true)->first();

        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tahun ajaran MI aktif belum ditentukan.');
        }

        // DEFAULT KELAS AWAL
        $kelasAwal = Kelas_Mi::where('tingkat', 1)->first();
        if (!$kelasAwal) {
            return back()->with('error', 'Kelas MI tingkat awal belum tersedia.');
        }

        Siswa_MI::create([
            'nama'            => $request->nama,
            'email'           => $request->email,
            'nisn'            => $request->nisn,
            'tahun'           => $request->tahun,
            'nama_wali'       => $request->nama_wali,
            'no_hp_wali'      => $request->no_hp_wali,
            'alamat_siswa'    => $request->alamat_siswa,
            'kelas_id'        => $request->kelas_id ?? $kelasAwal->id,
            'tahun_ajaran_id' => $tahunAjaranAktif->id, // ✅ KUNCI
        ]);

        return redirect()->route('siswa-mi.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }


    public function edit($id)
    {
        $siswa = Siswa_MI::findOrFail($id);
        $kelas = Kelas_Mi::orderBy('tingkat')->get();
        return view('mi.siswa-mi.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa_MI::findOrFail($id);
        $siswa->update($request->all());
        return redirect()->route('siswa-mi.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa_MI::findOrFail($id);
        $siswa->delete();
        return redirect()->route('siswa-mi.index')->with('success', 'Data berhasil dihapus');
    }

    public function show($id)
    {
        $siswa = Siswa_MI::with('kelas')->findOrFail($id);
        return view('mi.siswa-mi.show', compact('siswa'));
    }
}
