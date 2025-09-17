<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran_MI;
use App\Models\Siswa_MI;
use App\Models\Kelas_Mi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;

class PembayaranMiController extends Controller
{
    // Tampilkan semua data pembayaran
    public function index(Request $request)
    {
        $query = Pembayaran_MI::with('siswa');

        // Ambil semua daftar kelas
        $kelasList = Kelas_Mi::orderBy('tingkat', 'asc')->get();

        // Filter NISN
        if ($request->filled('nisn')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nisn', 'like', '%' . $request->nisn . '%');
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
            $pembayaran = new LengthAwarePaginator([], 0, 10);
        }

        return view('mi.pembayaran-mi.index', compact('pembayaran', 'kelasList'));
    }

    // Form tambah pembayaran
    public function create()
    {
        $kelasList = Kelas_Mi::orderBy('tingkat', 'asc')->get();
        $siswaList = Siswa_Mi::all();
        return view('mi.pembayaran-mi.create', compact('siswaList', 'kelasList'));
    }

    // Simpan pembayaran
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas_mi,id',
            'jumlah'   => 'required|numeric',
            'tanggal'  => 'required|date',
        ]);

        $bulan = \Carbon\Carbon::parse($request->tanggal)->month;
        $tahun = \Carbon\Carbon::parse($request->tanggal)->year;

        $siswa = Siswa_Mi::with('kelas')->find($request->siswa_id);

        // Cek jika siswa sudah lulus (kelas_id = 7)
        if ($siswa->kelas_id == 7) {
            return redirect()->back()->with('error', 'Pembayaran tidak dapat dilakukan. Siswa sudah lulus.');
        }

        $cekPembayaran = Pembayaran_MI::where('siswa_id', $request->siswa_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->first();

        if ($cekPembayaran) {
            return redirect()->back()->with('error', 'Pembayaran untuk siswa ini di bulan tersebut sudah ada.');
        }

        $pembayaran = Pembayaran_MI::create($request->all());

        return redirect()->route('pembayaran-mi.index', [
            'bulan' => $request->input('bulan'),
            'nisn' => $request->input('nisn'),
            'kelas_id' => $request->input('kelas_id'),
        ])->with('success', 'Pembayaran untuk siswa '
            . $pembayaran->siswa->nisn . ' - ' . $pembayaran->siswa->nama . ' berhasil ditambahkan.');
    }

    // Form edit pembayaran
    public function edit($id)
    {
        $pembayaran = Pembayaran_MI::findOrFail($id);
        $siswa = Siswa_Mi::all();
        // $siswa = Siswa_Mi::where('kelas_id', '!=', 7)->get();
        $kelasList = Kelas_Mi::all();
        return view('mi.pembayaran-mi.edit', compact('pembayaran', 'siswa', 'kelasList'));
    }

    // Update pembayaran
    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran_MI::findOrFail($id);

        $bulan = \Carbon\Carbon::parse($request->tanggal)->month;
        $tahun = \Carbon\Carbon::parse($request->tanggal)->year;
        
        $siswa = Siswa_Mi::with('kelas')->find($request->siswa_id);

        // Cek jika siswa sudah lulus (kelas_id = 7)
        if ($siswa->kelas_id == 7) {
            return redirect()->back()->with('error', 'Pembayaran tidak dapat dilakukan. Siswa sudah lulus.');
        }

        $cekPembayaran = Pembayaran_MI::where('siswa_id', $request->siswa_id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('id', '!=', $id)
            ->first();

        if ($cekPembayaran) {
            return redirect()->back()->with('error', 'Pembayaran untuk siswa ini di bulan tersebut sudah ada.');
        }

        $pembayaran->update($request->all());

        return redirect()->route('pembayaran-mi.index', [
            'bulan' => $request->input('bulan'),
            'nisn' => $request->input('nisn'),
            'kelas_id' => $request->input('kelas_id'),
        ])->with('success', 'Pembayaran untuk siswa '
            . $pembayaran->siswa->nisn . ' - ' . $pembayaran->siswa->nama . ' berhasil diperbarui.');
    }

    // Hapus pembayaran
    public function destroy(Request $request, $id)
    {
        $pembayaran = Pembayaran_MI::with('siswa')->findOrFail($id);
        $nama = $pembayaran->siswa->nama;
        $nisn = $pembayaran->siswa->nisn;

        $pembayaran->delete();

        return redirect()->route('pembayaran-mi.index', [
            'bulan' => $request->input('bulan'),
            'nisn' => $request->input('nisn'),
            'kelas_id' => $request->input('kelas_id'),
        ])->with('success', 'Pembayaran untuk siswa ' . $nisn . ' - ' . $nama . ' berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = Pembayaran_MI::with('siswa.kelas');

        $kelas = null;
        $kelasLabel = null;

        // Filter NISN
        if ($request->filled('nisn')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nisn', 'like', '%' . $request->nisn . '%');
            });
        }

        // 🔥 Filter Kelas
        if ($request->filled('kelas_id')) {
            $kelas = Kelas_Mi::find($request->kelas_id);
            $kelasLabel = $kelas ? $kelas->nama_kelas : null;

            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        // Filter Bulan
        if ($request->filled('bulan')) {
            $bulan = \Carbon\Carbon::parse($request->bulan);
            $query->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year);
        } else {
            return redirect()->route('pembayaran-mi.index')
                ->with('error', 'Silakan pilih bulan terlebih dahulu.');
        }

        // Ambil data hasil filter
        $pembayaran = $query->get();

        // Hitung total hanya yang lunas
        $total = $pembayaran->filter(fn($p) => strtolower($p->status) === 'lunas')
            ->sum('jumlah');

        $pdf = Pdf::loadView('mi.pembayaran-mi.export-pdf', compact(
            'pembayaran', 'total', 'bulan', 'kelasLabel'
        ))->setPaper('A4', 'portrait');

        $namaFile = 'laporan-pembayaran-' . $bulan->translatedFormat('F-Y');
        if ($kelasLabel) {
            $namaFile .= '-kelas-' . $kelasLabel;
        }
        $namaFile .= '.pdf';

        return $pdf->stream($namaFile);
    }

    public function kwitansiPdf($id)
    {
        $pembayaran = Pembayaran_MI::with('siswa')->findOrFail($id);
        $pdf = Pdf::loadView('mi.pembayaran-mi.kwitansi', compact('pembayaran'))
            ->setPaper([0, 0, 595.28, 320], 'portrait'); // 1/3 A4

        $namaFile = 'kwitansi-' . $pembayaran->id . '.pdf';
        return $pdf->stream($namaFile);
    }

    public function getSiswaDetail($siswaId)
    {
        $siswa = Siswa_MI::with('kelas')
                ->where('id', $siswaId)
                ->first(['id', 'nama', 'nisn', 'kelas_id']);

        if ($siswa) {
            return response()->json([
                'id' => $siswa->id,
                'nama' => $siswa->nama,
                'nisn' => $siswa->nisn,
                'kelas_id' => $siswa->kelas_id,
                'kelas_nama' => $siswa->kelas ? $siswa->kelas->nama_kelas : null
            ]);
        }

        return response()->json(null, 404);
    }

    // Form Generate SPP
    public function generateFormMI()
    {
        $kelasList = Kelas_Mi::orderBy('tingkat', 'asc')->get();
        return view('mi.pembayaran-mi.generate', compact('kelasList'));
    }

    // Proses Generate SPP
   public function generateSPPMI(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas_mi,id',
            'tahun'    => 'required|digits:4',
            'bulan'    => 'required|numeric|min:1|max:12',
            'jumlah_default' => 'required|numeric'
        ]);

        $kelas = Kelas_Mi::findOrFail($request->kelas_id);
        $siswaList = Siswa_MI::where('kelas_id', $kelas->id)->get();

        $generated = 0;
        $tanggal = \Carbon\Carbon::createFromDate($request->tahun, $request->bulan, 1);

        foreach ($siswaList as $siswa) {
            $cek = Pembayaran_MI::where('siswa_id', $siswa->id)
                ->whereMonth('tanggal', $tanggal->month)
                ->whereYear('tanggal', $tanggal->year)
                ->first();

            if (!$cek) {
                Pembayaran_MI::create([
                    'siswa_id' => $siswa->id,
                    'jumlah'   => $request->jumlah_default,
                    'tanggal'  => $tanggal,
                    'status'   => 'belum', // atau 'Belum Lunas'
                    'tanggal_bayar' => null
                ]);
                $generated++;
            }
        }

        return redirect()->route('pembayaran-mi.index', [
            'bulan' => $tanggal->format('Y-m'),
            'kelas_id' => $request->kelas_id
        ])->with('success', "SPP berhasil digenerate untuk $generated siswa di kelas {$kelas->nama_kelas}.");
    }

    public function approvePembayaran($id)
    {
        $pembayaran = Pembayaran_MI::findOrFail($id);

        if ($pembayaran->status == 'belum') {
            $pembayaran->update([
                'status' => 'lunas',
                'tanggal_bayar' => now()
            ]);
        }

        return redirect()->back()->with('success', "Pembayaran siswa {$pembayaran->siswa->nama} telah disetujui.");
    }
}
