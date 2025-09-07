<?php

namespace App\Http\Controllers;

use App\Models\Siswa_MI;
use App\Models\Kelas_Mi;
use Illuminate\Http\Request;

class SiswaMiController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa_MI::orderBy('nama');

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
            'nama'          => 'required|string|max:255',
            'nisn'          => 'required|string|unique:siswas_mi,nisn',
            'tahun'         => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'no_hp_wali'    => 'required|string|max:20',
            'alamat_siswa'  => 'required|string|max:255',
            'nama_wali'     => 'required|string|max:255',
            'kelas_id'      => 'nullable|exists:kelas_mi,id',
        ]);

        $data = $request->all();

        // Jika kelas tidak dipilih, default ke kelas 1
        if (empty($data['kelas_id'])) {
            $kelasAwal = \App\Models\Kelas_Mi::where('tingkat', 1)->first();
            if ($kelasAwal) {
                $data['kelas_id'] = $kelasAwal->id;
            }
        }

        Siswa_MI::create($data);

        return redirect()->route('siswa-mi.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = Siswa_MI::findOrFail($id);
        $kelas = \App\Models\Kelas_Mi::orderBy('tingkat')->get();
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

    public function naikKelas()
    {
        $siswas = Siswa_MI::with('kelas')->get();

        foreach ($siswas as $siswa) {
            // jika belum punya kelas, set default ke Kelas 1
            if (!$siswa->kelas) {
                $kelasAwal = Kelas_MI::where('tingkat', 1)->first();
                if ($kelasAwal) {
                    $siswa->update(['kelas_id' => $kelasAwal->id]);
                }
                continue; // lanjut ke siswa berikutnya
            }

            $kelasSekarang = $siswa->kelas;
            $kelasBerikut = Kelas_MI::where('tingkat', $kelasSekarang->tingkat + 1)->first();

            if ($kelasBerikut) {
                $siswa->update(['kelas_id' => $kelasBerikut->id]);
            }
            // kalau sudah "Lulus" (tingkat 7), biarkan tetap
        }

        return redirect()->back()->with('success', 'Proses kenaikan kelas selesai!');
    }

    public function show($id)
    {
        $siswa = Siswa_MI::with('kelas')->findOrFail($id);
        return view('mi.siswa-mi.show', compact('siswa'));
    }

}


