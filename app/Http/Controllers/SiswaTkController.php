<?php

namespace App\Http\Controllers;

use App\Models\SiswaTk;
use App\Models\KelasTk;
use Illuminate\Http\Request;

class SiswaTkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $siswa = SiswaTk::when($search, function ($query, $search) {
            return $query->where('id_tk', 'like', "%{$search}%")
                         ->orWhere('nama', 'like', "%{$search}%");
        })->paginate(10);

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
            'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'nama_wali' => 'required|string|max:100',
            'no_hp_wali' => 'nullable|string|max:20',
            'alamat_siswa' => 'nullable|string',
            'kelas_id'      => 'nullable|exists:kelas_tk,id',
        ]);

        $data = $request->all();

        // Jika kelas tidak dipilih, default ke kelas 1
        if (empty($data['kelas_id'])) {
            $kelasAwal = \App\Models\KelasTk::where('tingkat', 1)->first();
            if ($kelasAwal) {
                $data['kelas_id'] = $kelasAwal->id;
            }
        }

        SiswaTk::create($data);

        return redirect()->route('siswa-tk.index')
                         ->with('success', 'Data siswa berhasil ditambahkan.');
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

    public function naikKelasTk()
    {
        $siswas = SiswaTk::with('kelas')->get();

        foreach ($siswas as $siswa) {
            // Jika belum punya kelas, set default ke Kelas A (tingkat 1)
            if (!$siswa->kelas) {
                $kelasAwal = KelasTk::where('tingkat', 1)->first();
                if ($kelasAwal) {
                    $siswa->update(['kelas_id' => $kelasAwal->id]);
                }
                continue;
            }

            $kelasSekarang = $siswa->kelas;
            $kelasBerikut = KelasTk::where('tingkat', $kelasSekarang->tingkat + 1)->first();

            if ($kelasBerikut) {
                $siswa->update(['kelas_id' => $kelasBerikut->id]);
            }
            // Kalau sudah "Lulus", biarkan tetap
        }

        return redirect()->back()->with('success', 'Proses kenaikan kelas selesai!');
    }

    public function show($id)
    {
        $siswa = SiswaTk::with('kelas')->findOrFail($id);
        return view('tk.siswa-tk.show', compact('siswa'));
    }

}
