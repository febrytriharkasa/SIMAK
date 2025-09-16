<?php

namespace App\Http\Controllers;

use App\Models\EvaluasiKinerja;
use App\Models\User;
use Illuminate\Http\Request;

class EvaluasiKinerjaController extends Controller
{
    /**
     * Tampilkan daftar evaluasi.
     */
    public function index()
    {
        $evaluasi = EvaluasiKinerja::with('user')->latest()->paginate(10);
        return view('admin.evaluasi.index', compact('evaluasi'));
    }

    /**
     * Form tambah evaluasi.
     */
    public function create()
    {
        $users = User::all(); // daftar pegawai/guru
        return view('admin.evaluasi.create', compact('users'));
    }

    /**
     * Simpan evaluasi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'periode'        => 'required|string',
            'disiplin'       => 'required|numeric|min:0|max:100',
            'tanggung_jawab' => 'required|numeric|min:0|max:100',
            'kerjasama'      => 'required|numeric|min:0|max:100',
            'kompetensi'     => 'required|numeric|min:0|max:100',
            'kehadiran'      => 'required|numeric|min:0|max:100',
            'deskripsi'      => 'nullable|string',
        ]);

        EvaluasiKinerja::create($request->all());

        return redirect()->route('admin.evaluasi.index')->with('success', 'Evaluasi berhasil ditambahkan');
    }

    /**
     * Form edit evaluasi.
     */
    public function edit(EvaluasiKinerja $evaluasi)
    {
        $users = User::all();
        return view('evaluasi.edit', compact('evaluasi', 'users'));
    }

    /**
     * Update evaluasi.
     */
    public function update(Request $request, EvaluasiKinerja $evaluasi)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'periode'        => 'required|string',
            'disiplin'       => 'required|numeric|min:0|max:100',
            'tanggung_jawab' => 'required|numeric|min:0|max:100',
            'kerjasama'      => 'required|numeric|min:0|max:100',
            'kompetensi'     => 'required|numeric|min:0|max:100',
            'kehadiran'      => 'required|numeric|min:0|max:100',
            'deskripsi'      => 'nullable|string',
        ]);

        $evaluasi->update($request->all());

        return redirect()->route('admin.evaluasi.index')->with('success', 'Evaluasi berhasil diperbarui');
    }

    /**
     * Hapus evaluasi.
     */
    public function destroy(EvaluasiKinerja $evaluasi)
    {
        $evaluasi->delete();
        return redirect()->route('admin.evaluasi.index')->with('success', 'Evaluasi berhasil dihapus');
    }
}
