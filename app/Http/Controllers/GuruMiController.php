<?php

namespace App\Http\Controllers;

use App\Models\Guru_MI;
use Illuminate\Http\Request;

class GuruMiController extends Controller
{
    // Tampilkan semua data guru
    public function index(Request $request)
    {
        $query = Guru_MI::query();

        // Filter berdasarkan NIP
        if ($request->filled('nip')) {
            $query->where('nip', 'like', '%' . $request->nip . '%');
        }

        // Pagination
        $guru = $query->paginate(10);

        return view('mi.guru-mi.index', compact('guru'));
    }

    // Form tambah guru
    public function create()
    {
        return view('mi.guru-mi.create');
    }

    // Simpan data guru
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'nip'         => 'required|string|unique:gurus_mi,nip',
            'mapel'       => 'required|string|max:100',
            'no_hp_guru'  => 'required|string|max:20',
            'alamat_guru' => 'required|string|max:255',
        ]);

        Guru_MI::create($request->all());
        return redirect()->route('guru-mi.index')->with('success', 'Data Guru berhasil ditambahkan.');
    }

    // Form edit guru
    public function edit($id)
    {
        $guru = Guru_MI::findOrFail($id);
        return view('mi.guru-mi.edit', compact('guru'));
    }

    // Update data guru
    public function update(Request $request, $id)
    {
        $guru = Guru_MI::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:255',
            'nip'         => 'required|string|unique:gurus_mi,nip,' . $guru->id,
            'mapel'       => 'required|string|max:100',
            'no_hp_guru'  => 'required|string|max:20',
            'alamat_guru' => 'required|string|max:255',
        ]);

        $guru->update($request->all());
        return redirect()->route('guru-mi.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    // Hapus data guru
    public function destroy($id)
    {
        Guru_MI::findOrFail($id)->delete();
        return redirect()->route('guru-mi.index')->with('success', 'Data Guru berhasil dihapus.');
    }
}

