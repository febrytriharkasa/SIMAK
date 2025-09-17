<?php

namespace App\Http\Controllers;

use App\Models\Guru_MI;
use App\Models\MapelMi;
use Illuminate\Http\Request;

class GuruMiController extends Controller
{
    // Tampilkan semua data guru
    public function index(Request $request)
    {
        $query = Guru_MI::with('mapels'); // eager load relasi mapel

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
        $mapelList = MapelMi::all(); // ambil semua mapel
        return view('mi.guru-mi.create', compact('mapelList'));
    }

    // Simpan data guru
    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'nip'         => 'required|string|unique:gurus_mi,nip',
            'mapel'       => 'required|array',
            'mapel.*'     => 'exists:mapel_mi,id',
            'no_hp_guru'  => 'required|string|max:20',
            'alamat_guru' => 'required|string|max:255',
        ]);

        $guru = Guru_MI::create($request->only(['nama', 'nip', 'no_hp_guru', 'alamat_guru']));

        // simpan relasi ke tabel pivot
        $guru->mapels()->attach($request->mapel);

        return redirect()->route('guru-mi.index')->with('success', 'Data Guru berhasil ditambahkan.');
    }

    // Form edit guru
    public function edit($id)
    {
        $guru = Guru_MI::with('mapels')->findOrFail($id);
        $mapelList = MapelMi::all();
        return view('mi.guru-mi.edit', compact('guru', 'mapelList'));
    }

    // Update data guru
    public function update(Request $request, $id)
    {
        $guru = Guru_MI::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:255',
            'nip'         => 'required|string|unique:gurus_mi,nip,' . $guru->id,
            'mapel'       => 'required|array',
            'mapel.*'     => 'exists:mapel_mi,id',
            'no_hp_guru'  => 'required|string|max:20',
            'alamat_guru' => 'required|string|max:255',
        ]);

        $guru->update($request->only(['nama', 'nip', 'no_hp_guru', 'alamat_guru']));

        // update relasi mapel (sync)
        $guru->mapels()->sync($request->mapel);

        return redirect()->route('guru-mi.index')->with('success', 'Data Guru berhasil diperbarui.');
    }

    // Hapus data guru
    public function destroy($id)
    {
        $guru = Guru_MI::findOrFail($id);

        // hapus relasi pivot dulu
        $guru->mapels()->detach();

        $guru->delete();

        return redirect()->route('guru-mi.index')->with('success', 'Data Guru berhasil dihapus.');
    }

    // Detail data guru
    public function show($id)
    {
        $guru = Guru_MI::with('mapels')->findOrFail($id);
        return view('mi.guru-mi.show', compact('guru'));
    }
}
