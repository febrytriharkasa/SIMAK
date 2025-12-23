<?php

namespace App\Http\Controllers;

use App\Models\NilaiTk;
use App\Models\SiswaTk;
use App\Models\MapelTk;
use App\Models\GuruTk;
use App\Models\KelasTk;
use App\Models\AbsensiTk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class NilaiTkController extends Controller
{
    // Menampilkan daftar nilai
    public function index(Request $request)
    {
        // Ambil semua kelas untuk dropdown filter
        $kelasList = KelasTk::all();

        // Ambil parameter filter kelas dari request
        $kelasId = $request->kelas_id;

        // Query siswa, filter berdasarkan kelas jika dipilih
        $query = SiswaTk::with('kelas');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        // Gunakan paginate agar bisa pakai ->links()
        $siswas = $query->paginate(10);

        return view('tk.nilai-tk.index', compact('siswas', 'kelasList', 'kelasId'));
    }


    // Menampilkan form tambah nilai
    public function create()
    {
        // Ambil semua kelas beserta siswa
        $kelasList = KelasTk::where('tingkat', '<', 4)
            ->orderBy('tingkat')
            ->get();

        // Ambil semua mapel beserta guru
        $mapelList = MapelTk::with('guru')->get();

        return view('tk.nilai-tk.create', compact('kelasList', 'mapelList'));
    }


    // Menyimpan data nilai baru
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas_tk,id',
            'mapel_id' => 'required|exists:mapel_tk,id',
            'semester' => 'required|in:ganjil,genap',
            'nilai'    => 'required|array', // array siswa
        ]);

        foreach ($request->nilai as $siswaId => $data) {
            // Validasi setiap siswa
            $tugas = isset($data['tugas']) ? array_map('floatval', $data['tugas']) : [];
            $uts   = isset($data['uts']) ? floatval($data['uts']) : null;
            $eas   = isset($data['uas']) ? floatval($data['uas']) : null; // asumsi uas = eas

            if (empty($tugas) || is_null($uts) || is_null($eas)) {
                continue; // lewati siswa jika data tidak lengkap
            }

            $exists = NilaiTk::where([
                'siswa_id' => $siswaId,
                'mapel_id' => $request->mapel_id,
                'kelas_id' => $request->kelas_id,
                'semester' => $request->semester,
            ])->exists();

            if ($exists) {
                continue; // atau return error
            }

            // Hitung nilai_akhir otomatis
            $rataTugas = array_sum($tugas) / count($tugas);
            $nilaiAkhir = ($rataTugas * 0.3) + ($uts * 0.35) + ($eas * 0.35);

            // Simpan ke database
            NilaiTk::create([
                'siswa_id'    => $siswaId,
                'mapel_id'    => $request->mapel_id,
                'kelas_id'    => $request->kelas_id,
                'semester'    => $request->semester,
                'tugas'       => $tugas,
                'uts'         => $uts,
                'eas'         => $eas,
                'nilai_akhir' => round($nilaiAkhir, 2),
            ]);
        }

        return redirect()->route('nilai-tk.index')->with('success', 'Data nilai berhasil ditambahkan!');
    }

    // Menampilkan form edit nilai
    public function edit(NilaiTk $nilai)
    {
        $siswa = SiswaTk::all();
        $mapel = MapelTk::all();
        $guru = GuruTk::all();
        $kelas = KelasTk::all();
        return view('tk.nilai-tk.edit', compact('nilai', 'siswa', 'mapel', 'guru', 'kelas'));
    }

    // Mengupdate data nilai
    public function update(Request $request, NilaiTk $nilai)
    {
        // Konversi string tugas menjadi array
        if (is_string($request->tugas)) {
            $request->merge([
                'tugas' => array_map('trim', explode(',', $request->tugas))
            ]);
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswa_tk,id',
            'mapel_id' => 'required|exists:mapel_tk,id',
            'kelas_id' => 'required|exists:kelas_tk,id',
            'tugas'    => 'required|array',
            'uts'      => 'required|numeric|min:0|max:100',
            'eas'      => 'required|numeric|min:0|max:100',
        ]);

        // Hitung nilai_akhir otomatis
        $rataTugas = array_sum($request->tugas) / count($request->tugas);
        $nilaiAkhir = ($rataTugas * 0.3) + ($request->uts * 0.35) + ($request->eas * 0.35);

        $nilai->update(array_merge($request->all(), [
            'nilai_akhir' => round($nilaiAkhir, 2)
        ]));


        return redirect()->route('nilai-tk.index')->with('success', 'Data nilai berhasil diperbarui!');
    }


    // Menghapus data nilai
    public function destroy(NilaiTk $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai-tk.index')->with('success', 'Data nilai berhasil dihapus!');
    }

    public function show($id, Request $request)
    {
        $siswa = SiswaTk::with('kelas')->findOrFail($id);

        // kelas aktif (default = kelas siswa sekarang)
        $kelasId = $request->kelas_id ?? $siswa->kelas_id;

        // semester (opsional)
        $semester = $request->semester; // ganjil | genap | null

        // ambil nilai berdasarkan siswa + kelas + semester (jika ada)
        $nilais = NilaiTk::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->where('kelas_id', $kelasId)
            ->when($semester, function ($q) use ($semester) {
                $q->where('semester', $semester);
            })
            ->orderBy('semester')
            ->orderBy('mapel_id')
            ->get();

        $kelasList = KelasTk::orderBy('tingkat')->get();

        return view('tk.nilai-tk.show', compact(
            'siswa',
            'nilais',
            'kelasList',
            'kelasId',
            'semester'
        ));
    }

    public function cetakRaporPdfAllKelas($siswaId)
    {
        $siswa = SiswaTk::with('kelas', 'absensis')->findOrFail($siswaId);

        $kelasList = KelasTk::where('tingkat', '<=', $siswa->kelas->tingkat)
            ->orderBy('tingkat')
            ->get();

        $mapels = MapelTk::orderBy('nama_mapel')->get(); // ambil semua mapel

        $dataRapor = [];

        foreach ($kelasList as $kelas) {
            foreach (['ganjil', 'genap'] as $semester) {
                $nilais = NilaiTk::with('mapel')
                    ->where('siswa_id', $siswa->id)
                    ->where('kelas_id', $kelas->id)
                    ->where('semester', $semester)
                    ->get();

                $rataRata = $nilais->count() ? round($nilais->avg('nilai_akhir'), 2) : 0;

                $status = '-';
                if ($semester === 'genap' && $nilais->count()) {
                    $status = $rataRata >= 70 ? 'NAIK KELAS' : 'TINGGAL KELAS';
                }

                $absensi = $siswa->absensis->where('semester', $semester);
                $absensiSummary = [
                    'hadir' => $absensi->where('status', 'hadir')->count(),
                    'izin'  => $absensi->where('status', 'izin')->count(),
                    'sakit' => $absensi->where('status', 'sakit')->count(),
                    'alfa'  => $absensi->where('status', 'alfa')->count(),
                ];

                // siapkan nilai per mapel (walau belum ada)
                $nilaiPerMapel = $mapels->map(function ($mapel) use ($nilais) {
                    $nilai = $nilais->firstWhere('mapel_id', $mapel->id);
                    return [
                        'mapel' => $mapel,
                        'nilai_akhir' => $nilai->nilai_akhir ?? null,
                    ];
                });

                $dataRapor[] = [
                    'kelas' => $kelas,
                    'semester' => $semester,
                    'nilais' => $nilaiPerMapel,
                    'rataRata' => $rataRata,
                    'status' => $status,
                    'absensi' => $absensiSummary,
                ];
            }
        }

        $pdf = Pdf::loadView('tk.nilai-tk.rapor-pdf', [
            'siswa' => $siswa,
            'dataRapor' => $dataRapor,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Rapor_' . $siswa->nama . '.pdf');
    }
}
