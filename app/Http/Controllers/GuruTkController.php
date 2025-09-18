<?php

namespace App\Http\Controllers;

use App\Models\GuruTk;
use App\Models\MapelTk;
use Illuminate\Http\Request;

class GuruTkController extends Controller
{
    public function index(Request $request)
    {
        $query = GuruTk::with('mapels'); // eager load relasi mapel

        // Filter berdasarkan NIP
        if ($request->filled('nip')) {
            $query->where('nip', 'like', '%' . $request->nip . '%');
        }

        // Pagination
        $guru = $query->paginate(10);

        return view('tk.guru-tk.index', compact('guru'));
    }

    public function create()
    {
        $mapelList = MapelTk::all();
        return view('tk.guru-tk.create', compact('mapelList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:guru_tk,nip',
            'mapel'       => 'required|array',
            'mapel.*'     => 'exists:mapel_tk,id',
            'no_hp_guru' => 'nullable|string|max:20',
            'alamat_guru' => 'nullable|string',
        ]);

        $guru = GuruTk::create($request->only(['nama', 'nip', 'no_hp_guru', 'alamat_guru']));

        // simpan relasi ke tabel pivot
        $guru->mapels()->attach($request->mapel);

        return redirect()->route('guru-tk.index')
                         ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = GuruTk::with('mapels')->findOrFail($id);
        $mapelList = MapelTk::all();
        return view('tk.guru-tk.edit', compact('guru', 'mapelList'));
    }

    public function update(Request $request, $id)
    {
        $guru = GuruTk::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:guru_tk,nip,' . $guru->id,
            'mapel'       => 'required|array',
            'mapel.*'     => 'exists:mapel_tk,id',
            'no_hp_guru' => 'nullable|string|max:20',
            'alamat_guru' => 'nullable|string',
        ]);

        $guru->update($request->only(['nama', 'nip', 'no_hp_guru', 'alamat_guru']));

        $guru->mapels()->sync($request->mapel);

        return redirect()->route('guru-tk.index')
                         ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guru = GuruTk::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru-tk.index')
                         ->with('success', 'Data guru berhasil dihapus.');
    }

    public function show($id)
    {
        $guru = GuruTk::findOrFail($id);
        return view('tk.guru-tk.show', compact('guru'));
    }
}
