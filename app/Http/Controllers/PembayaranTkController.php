<?php

namespace App\Http\Controllers;

use App\Models\PembayaranTk;
use App\Models\SiswaTk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranTkController extends Controller
{
    // 📌 Tampilkan semua data pembayaran
    public function index(Request $request)
    {
        $query = PembayaranTk::with('siswa');

        // Ambil daftar tahun unik dari siswa TK
        $tahunList = SiswaTk::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        // Filter No Induk
        if ($request->filled('id_tk')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('id_tk', 'like', '%' . $request->id_tk . '%');
            });
        }

        // Filter Tahun Angkatan
        if ($request->filled('tahun_angkatan')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('tahun', $request->tahun_angkatan);
            });
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $bulan = \Carbon\Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                  ->whereYear('tanggal', $bulan->year);

            $pembayaran = $query->paginate(10);
        } else {
            $pembayaran = collect([]); // kosongkan jika belum pilih bulan
        }

        return view('tk.pembayaran-tk.index', compact('pembayaran', 'tahunList'));
    }

    // 📌 Cetak kwitansi per pembayaran
    public function kwitansiPdf($id)
    {
        $pembayaran = PembayaranTk::with('siswa')->findOrFail($id);

        $pdf = Pdf::loadView('tk.pembayaran-tk.kwitansi', compact('pembayaran'))
                  ->setPaper([0, 0, 595.28, 280], 'portrait'); // 1/3 A4

        return $pdf->stream('kwitansi-' . $pembayaran->id . '.pdf');
    }

    // 📌 Form tambah pembayaran
    public function create()
    {
        $siswa = SiswaTk::all();
        $tahunList = SiswaTk::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        return view('tk.pembayaran-tk.create', compact('siswa', 'tahunList'));
    }

    // 📌 Simpan pembayaran baru
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa_tk,id',
            'jumlah'   => 'required|numeric',
            'tanggal'  => 'required|date',
        ]);

        $bulan = \Carbon\Carbon::parse($request->tanggal)->month;
        $tahun = \Carbon\Carbon::parse($request->tanggal)->year;

        // Cek duplikat pembayaran di bulan/tahun untuk siswa tsb
        $cek = PembayaranTk::where('siswa_id', $request->siswa_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->first();

        if ($cek) {
            return back()->with('error', 'Pembayaran untuk bulan ini sudah ada.');
        }

        $pembayaran = PembayaranTk::create($request->all());

        return redirect()->route('pembayaran-tk.index', [
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'id_tk' => $request->input('id_tk'),
            'tahun_angkatan' => $request->input('tahun_angkatan'), // tambahan
        ])->with('success', 'Pembayaran untuk siswa '
            . $pembayaran->siswa->id_tk . ' - ' . $pembayaran->siswa->nama . ' berhasil ditambahkan.');
    }

    // 📌 Form edit pembayaran
    public function edit($id)
    {
        $pembayaran = PembayaranTk::findOrFail($id);
        $siswa = SiswaTk::all();
        return view('tk.pembayaran-tk.edit', compact('pembayaran', 'siswa'));
    }

    // 📌 Update pembayaran
    public function update(Request $request, $id)
    {
        $pembayaran = PembayaranTk::findOrFail($id);

        $pembayaran->update([
            'siswa_id' => $request->siswa_id,
            'jumlah'   => $request->jumlah,
            'tanggal'  => $request->tanggal,
            'status'   => strtolower($request->status), // selalu simpan lowercase
        ]);

        $bulan = \Carbon\Carbon::parse($request->tanggal)->month;
        $tahun = \Carbon\Carbon::parse($request->tanggal)->year;

        // Cek duplikat (kecuali data yang sedang diupdate)
        $cek = PembayaranTk::where('siswa_id', $request->siswa_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('id', '!=', $id)
            ->first();

        if ($cek) {
            return back()->with('error', 'Pembayaran untuk bulan ini sudah ada.');
        }

        $pembayaran->update($request->all());

        return redirect()->route('pembayaran-tk.index', [
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'id_tk' => $request->input('id_tk'),
            'tahun_angkatan' => $request->input('tahun_angkatan'),
        ])->with('success', 'Pembayaran untuk siswa '
            . $pembayaran->siswa->id_tk . ' - ' . $pembayaran->siswa->nama . ' berhasil diperbarui.');
    }

    // 📌 Hapus pembayaran
    public function destroy(Request $request, $id)
    {
        $pembayaran = PembayaranTk::with('siswa')->findOrFail($id);
        $nama = $pembayaran->siswa->nama;
        $id_tk = $pembayaran->siswa->id_tk;

        $pembayaran->delete(); 

        return redirect()->route('pembayaran-tk.index', [
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'id_tk' => $request->input('id_tk'),
            'tahun_angkatan' => $request->input('tahun_angkatan'),
        ])->with('success', 'Pembayaran untuk siswa '
            . $id_tk . ' - ' . $nama. ' berhasil dihapus.');
    }

    // 📌 Export laporan PDF (filter per bulan & tahun)
    public function exportPdf(Request $request)
    {
        $query = PembayaranTk::with('siswa');
        $tahun = null;
        $angkatanLabel = null;

        if ($request->filled('id_tk')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('id_tk', 'like', '%'.$request->id_tk.'%');
            });
        }

        if ($request->filled('tahun')) {
            $tahun = $request->tahun;
            $query->whereHas('siswa', fn($q) => $q->where('tahun', (int) $tahun));
            $angkatanLabel = $tahun . '/' . ((int)$tahun + 1);
        }

        if ($request->filled('bulan')) {
            $bulan = \Carbon\Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                  ->whereYear('tanggal', $bulan->year);
        } else {
            return redirect()->route('pembayaran-tk.index')
                ->with('error', 'Silakan pilih bulan terlebih dahulu.');
        }

        $pembayaran = $query->get();
        $total = $pembayaran->where('status', 'lunas')->sum('jumlah');

        $pdf = Pdf::loadView('tk.pembayaran-tk.export-pdf', compact(
            'pembayaran', 'total', 'bulan', 'tahun', 'angkatanLabel'
        ))->setPaper('A4', 'portrait');

        return $pdf->stream('laporan-pembayaran-' . $bulan->format('F-Y') . '.pdf');
    }
}
