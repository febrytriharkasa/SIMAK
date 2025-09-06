<?php

namespace App\Http\Controllers;

use App\Models\SiswaTk;
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
        return view('tk.siswa-tk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tk' => 'required|unique:siswa_tk,id_tk',
            'nama' => 'required|string|max:100',
            'tahun' => 'required|digits:4',
            'nama_wali' => 'required|string|max:100',
            'no_hp_wali' => 'nullable|string|max:20',
            'alamat_siswa' => 'nullable|string',
        ]);

        SiswaTk::create($request->all());

        return redirect()->route('siswa-tk.index')
                         ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(SiswaTk $siswa_tk)
    {
        return view('tk.siswa-tk.edit', compact('siswa_tk'));
    }

    public function update(Request $request, SiswaTk $siswa_tk)
    {
        $request->validate([
            'id_tk' => 'required|unique:siswa_tk,id_tk,' . $siswa_tk->id,
            'nama' => 'required|string|max:100',
            'tahun' => 'required|digits:4',
            'nama_wali' => 'required|string|max:100',
            'no_hp_wali' => 'nullable|string|max:20',
            'alamat_siswa' => 'nullable|string',
        ]);

        $siswa_tk->update($request->all());

        return redirect()->route('siswa-tk.index')
                        ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(SiswaTk $siswa_tk)
    {
        $siswa_tk->delete();

        return redirect()->route('siswa-tk.index')
                         ->with('success', 'Data siswa berhasil dihapus.');
    }
}
