<?php

namespace App\Http\Controllers;

use App\Models\SiswaTk;
use App\Models\KelasTk;
use App\Models\MapelTk;
use App\Models\TahunAjaranTk;
use Illuminate\Http\Request;

class SiswaTkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $siswa = SiswaTk::with('tahunAjaran') // 🔑 KUNCI
            ->when($search, function ($query, $search) {
                $query->where('id_tk', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%");
            })
            ->orderBy('id_tk')
            ->paginate(10);

        return view('tk.siswa-tk.index', compact('siswa'));
    }


    public function create()
    {
        $kelas = KelasTk::orderBy('tingkat')->get();
        return view('tk.siswa-tk.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tk' => 'required|unique:siswa_tk,id_tk',
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:siswa_tk,email',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'nama_wali' => 'required|string|max:100',
            'no_hp_wali' => 'nullable|string|max:20',
            'alamat_siswa' => 'nullable|string',
            'kelas_id' => 'nullable|exists:kelas_tk,id',
        ]);

        // 🔥 AMBIL TAHUN AJARAN AKTIF
        $tahunAjaranAktif = TahunAjaranTk::where('aktif', true)->first();

        if (!$tahunAjaranAktif) {
            return back()->with('error', 'Tahun ajaran TK aktif belum ditentukan.');
        }

        // DEFAULT KELAS TK AWAL (TINGKAT 1)
        $kelasAwal = KelasTk::where('tingkat', 1)->first();
        if (!$kelasAwal) {
            return back()->with('error', 'Kelas TK tingkat awal belum tersedia.');
        }

        SiswaTk::create([
            'id_tk'            => $request->id_tk,
            'nama'             => $request->nama,
            'email'            => $request->email,
            'tahun'            => $request->tahun,
            'nama_wali'        => $request->nama_wali,
            'no_hp_wali'       => $request->no_hp_wali,
            'alamat_siswa'     => $request->alamat_siswa,
            'kelas_id'         => $request->kelas_id ?? $kelasAwal->id,
            'tahun_ajaran_id'  => $tahunAjaranAktif->id, // ✅ KUNCI UTAMA
        ]);

        return redirect()->route('siswa-tk.index')
            ->with('success', 'Data siswa TK berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $siswa = SiswaTk::findOrFail($id);
        $kelas = KelasTk::orderBy('tingkat')->get();
        return view('tk.siswa-tk.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = SiswaTk::findOrFail($id);
        $siswa->update($request->all());

        return redirect()->route('siswa-tk.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = SiswaTk::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa-tk.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function show($id)
    {
        $siswa = SiswaTk::with('kelas')->findOrFail($id);
        return view('tk.siswa-tk.show', compact('siswa'));
    }
}
