<?php

namespace App\Http\Controllers;

use App\Models\GuruTk;
use Illuminate\Http\Request;

class GuruTkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $guru = GuruTk::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('nip', 'like', "%{$search}%")
                         ->orWhere('mapel', 'like', "%{$search}%");
        })->paginate(10);

        return view('tk.guru-tk.index', compact('guru'));
    }

    public function create()
    {
        return view('tk.guru-tk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:guru_tk,nip',
            'mapel' => 'required|string|max:100',
            'no_hp_guru' => 'nullable|string|max:20',
            'alamat_guru' => 'nullable|string',
        ]);

        GuruTk::create($request->all());

        return redirect()->route('guru-tk.index')
                         ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guru = GuruTk::findOrFail($id);
        return view('tk.guru-tk.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = GuruTk::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'required|string|max:50|unique:guru_tk,nip,' . $guru->id,
            'mapel' => 'required|string|max:100',
            'no_hp_guru' => 'nullable|string|max:20',
            'alamat_guru' => 'nullable|string',
        ]);

        $guru->update($request->all());

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
