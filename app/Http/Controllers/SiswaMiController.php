<?php

namespace App\Http\Controllers;

use App\Models\Siswa_MI;
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

        return view('siswa-mi.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa-mi.create');
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
        ]);

        Siswa_MI::create($request->all());
        return redirect()->route('siswa-mi.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $siswa = Siswa_MI::findOrFail($id);
        return view('siswa-mi.edit', compact('siswa'));
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
}


