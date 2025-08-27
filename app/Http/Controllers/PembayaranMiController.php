<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran_MI;
use App\Models\Siswa_MI;
use Illuminate\Http\Request;

class PembayaranMiController extends Controller
{
    // Tampilkan semua data pembayaran
    public function index(Request $request)
    {
        $query = Pembayaran_MI::with('siswa');

        // Filter NISN
        if ($request->filled('nisn')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nisn', 'like', '%'.$request->nisn.'%');
            });
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $bulan = \Carbon\Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year);
        }

        $pembayaran = $query->paginate(10);

        return view('pembayaran-mi.index', compact('pembayaran'));
    }

    public function kwitansi($id)
    {
        $pembayaran = Pembayaran_MI::with('siswa')->findOrFail($id);
        return view('pembayaran-mi.kwitansi', compact('pembayaran'));
    }
    // Form tambah pembayaran
    public function create()
    {
        $siswa = Siswa_MI::all(); // agar bisa pilih siswa MI
        return view('pembayaran-mi.create', compact('siswa'));
    }

    // Simpan pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas_mi,id', // sesuaikan dengan nama tabel migration
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date', // di model field-nya 'tanggal', bukan 'tanggal_bayar'
        ]);

        Pembayaran_MI::create($request->all());
        return redirect()->route('pembayaran-mi.index')->with('success', 'Data Pembayaran berhasil ditambahkan.');
    }

    // Form edit pembayaran
    public function edit($id)
    {
        $pembayaran = Pembayaran_MI::findOrFail($id);
        $siswa = Siswa_MI::all();
        return view('pembayaran-mi.edit', compact('pembayaran', 'siswa'));
    }

    // Update pembayaran
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran_MI::findOrFail($id);

        $request->validate([
            'siswa_id' => 'required|exists:siswas_mi,id',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        $pembayaran->update($request->all());
        return redirect()->route('pembayaran-mi.index')->with('success', 'Data Pembayaran berhasil diperbarui.');
    }

    // Hapus pembayaran
    public function destroy($id)
    {
        Pembayaran_MI::findOrFail($id)->delete();
        return redirect()->route('pembayaran-mi.index')->with('success', 'Data Pembayaran berhasil dihapus.');
    }
}
