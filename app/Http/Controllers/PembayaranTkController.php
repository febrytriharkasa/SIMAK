<?php

namespace App\Http\Controllers;

use App\Models\PembayaranTk;
use App\Models\SiswaTk;
use App\Models\KelasTk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranTkController extends Controller
{
    // 📌 Tampilkan semua data pembayaran
    public function index(Request $request)
    {
        $query = PembayaranTk::with('siswa');

        // Ambil semua daftar kelas
        $kelasList = KelasTk::orderBy('tingkat', 'asc')->get();

        // Filter No Induk
        if ($request->filled('id_tk')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('id_tk', 'like', '%' . $request->id_tk . '%');
            });
        }

        // 🔥 Filter Kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
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

        return view('tk.pembayaran-tk.index', compact('pembayaran', 'kelasList'));
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
        $kelasList = KelasTk::orderBy('tingkat', 'asc')->get();
        return view('tk.pembayaran-tk.create', compact('siswa', 'kelasList'));
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
            return redirect()->back()->with('error', 'Pembayaran untuk siswa ini di bulan tersebut sudah ada.');
        }

        $pembayaran = PembayaranTk::create($request->all());

        return redirect()->route('pembayaran-tk.index', [
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'id_tk' => $request->input('id_tk'),
            'kelas_id' => $request->input('kelas_id'), // tambahan
        ])->with('success', 'Pembayaran untuk siswa '
            . $pembayaran->siswa->id_tk . ' - ' . $pembayaran->siswa->nama . ' berhasil ditambahkan.');
    }

    // 📌 Form edit pembayaran
    public function edit($id)
    {
        $pembayaran = PembayaranTk::findOrFail($id);
        $siswa = SiswaTk::all();
        $kelasList = KelasTk::all();
        return view('tk.pembayaran-tk.edit', compact('pembayaran', 'siswa', 'kelasList'));
    }

    // 📌 Update pembayaran
    public function update(Request $request, $id)
    {
        $pembayaran = PembayaranTk::findOrFail($id);

        // $pembayaran->update([
        //     'siswa_id' => $request->siswa_id,
        //     'jumlah'   => $request->jumlah,
        //     'tanggal'  => $request->tanggal,
        //     'status'   => strtolower($request->status), // selalu simpan lowercase
        // ]);

        $bulan = \Carbon\Carbon::parse($request->tanggal)->month;
        $tahun = \Carbon\Carbon::parse($request->tanggal)->year;

        // Cek duplikat (kecuali data yang sedang diupdate)
        $cek = PembayaranTk::where('siswa_id', $request->siswa_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('id', '!=', $id)
            ->first();

        if ($cek) {
            return redirect()->back()->with('error', 'Pembayaran untuk siswa ini di bulan tersebut sudah ada.');
        }

        $pembayaran->update($request->all());

        return redirect()->route('pembayaran-tk.index', [
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'id_tk' => $request->input('id_tk'),
            'kelas_id' => $request->input('kelas_id'),
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
            'kelas_id' => $request->input('kelas_id'),
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

        // 🔥 Filter Kelas
        if ($request->filled('kelas_id')) {
            $kelas = KelasTk::find($request->kelas_id);
            $kelasLabel = $kelas ? $kelas->nama_kelas : null;

            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
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
        // Hitung total hanya yang lunas
        $total = $pembayaran->filter(fn($p) => strtolower($p->status) === 'lunas')
            ->sum('jumlah');

        $pdf = Pdf::loadView('tk.pembayaran-tk.export-pdf', compact(
            'pembayaran', 'total', 'bulan', 'tahun', 'kelasLabel'
        ))->setPaper('A4', 'portrait');

        $namaFile = 'laporan-pembayaran-' . $bulan->translatedFormat('F-Y');
        if ($kelasLabel) {
            $namaFile .= '-kelas-' . $kelasLabel;
        }
        $namaFile .= '.pdf';

        return $pdf->stream($namaFile);
    }

    public function getSiswaDetail($siswaId)
    {
        $siswa = SiswaTk::with('kelas')
                ->where('id', $siswaId)
                ->first(['id', 'nama', 'id_tk', 'kelas_id']);

        if ($siswa) {
            return response()->json([
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'id_tk' => $siswa->id_tk,
                'kelas_id' => $siswa->kelas_id,
                'kelas_nama' => $siswa->kelas ? $siswa->kelas->nama_kelas : null
            ]);
        }

        return response()->json(null, 404);
    }
}
