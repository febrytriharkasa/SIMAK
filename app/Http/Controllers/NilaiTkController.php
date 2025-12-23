<?php

namespace App\Http\Controllers;

use App\Models\NilaiTk;
use App\Models\SiswaTk;
use App\Models\MapelTk;
use App\Models\GuruTk;
use App\Models\KelasTk;
use App\Models\AbsensiTk;
use App\Models\TahunAjaranMI;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NilaiTkController extends Controller
{
    // Menampilkan daftar nilai
    public function index(Request $request)
    {
        $kelasList = KelasTk::orderBy('tingkat')->get();
        $kelasId = $request->kelas_id;

        $siswas = SiswaTk::with([
            'kelas',
            'nilais.tahunAjaran'
        ])
            ->where('status', 'aktif')
            ->when($kelasId, fn($q) => $q->where('kelas_id', $kelasId))
            ->paginate(10);

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
            'nilai'    => 'required|array',
        ]);

        $tahunAjaranAktif = TahunAjaranMI::where('aktif', true)->firstOrFail();

        foreach ($request->nilai as $siswaId => $data) {
            
            $siswa = SiswaTk::find($siswaId);

            // Jika siswa tidak aktif (pending/reject), skip
            if (!$siswa || $siswa->status !== 'aktif') {
                continue;
            }

            if (
                empty($data['tugas']) ||
                !isset($data['uts']) ||
                !isset($data['uas'])
            ) {
                continue;
            }

            $tugas = array_map('floatval', $data['tugas']);
            $uts   = floatval($data['uts']);
            $eas   = floatval($data['uas']);

            $exists = NilaiTk::where([
                'siswa_id'        => $siswaId,
                'mapel_id'        => $request->mapel_id,
                'kelas_id'        => $request->kelas_id,
                'semester'        => $request->semester,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
            ])->exists();

            if ($exists) continue;

            $rataTugas = array_sum($tugas) / count($tugas);
            $nilaiAkhir = ($rataTugas * 0.3) + ($uts * 0.35) + ($eas * 0.35);

            NilaiTk::create([
                'siswa_id'        => $siswaId,
                'mapel_id'        => $request->mapel_id,
                'kelas_id'        => $request->kelas_id,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
                'semester'        => $request->semester,
                'tugas'           => $tugas,
                'uts'             => $uts,
                'eas'             => $eas,
                'nilai_akhir'     => round($nilaiAkhir),
            ]);
        }

        return redirect()->route('nilai-tk.index')
            ->with('success', 'Data nilai berhasil disimpan.');
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
        $siswa = SiswaTk::with(['kelas', 'absensis'])->findOrFail($siswaId);

        $kelasList = KelasTk::where('tingkat', '<=', $siswa->kelas->tingkat)
            ->orderBy('tingkat')
            ->get();

        $mapels = MapelTk::orderBy('nama_mapel')->get();            
        $dataRapor = [];

        foreach ($kelasList as $kelas) {
            foreach (['ganjil', 'genap'] as $semester) {

                // AMBIL NILAI
                $nilais = NilaiTk::with(['mapel', 'tahunAjaran'])
                    ->where('siswa_id', $siswa->id)
                    ->where('kelas_id', $kelas->id)
                    ->where('semester', $semester)
                    ->get();

                // ⛔ JIKA TIDAK ADA NILAI → JANGAN LANJUT
                if ($nilais->isEmpty()) {
                    continue;
                }

                // ⛔ AMBIL LANGSUNG DARI RELASI
                $tahunAjaran = $nilais->first()->tahunAjaran;

                // ⛔ JIKA TIDAK ADA TAHUN AJARAN → DATA RUSAK

                $rataRata = round($nilais->avg('nilai_akhir'), 2);

                $status = '-';
                if ($semester === 'genap') {
                    $status = $rataRata >= 70 ? 'NAIK KELAS' : 'TINGGAL KELAS';
                }

                $absensiSemester = $siswa->absensis->filter(function ($absen) use ($semester) {
                    $bulan = Carbon::parse($absen->tanggal)->month;
                    return $semester === 'ganjil'
                        ? ($bulan >= 7 && $bulan <= 12)
                        : ($bulan >= 1 && $bulan <= 6);
                });

                $absensiSummary = [
                    'hadir' => $absensiSemester->where('status', 'hadir')->count(),
                    'izin'  => $absensiSemester->where('status', 'izin')->count(),
                    'sakit' => $absensiSemester->where('status', 'sakit')->count(),
                    'alfa'  => $absensiSemester->where('status', 'alfa')->count(),
                ];

                $nilaiPerMapel = $mapels->map(function ($mapel) use ($nilais) {
                    $nilai = $nilais->firstWhere('mapel_id', $mapel->id);
                    return [
                        'mapel' => $mapel,
                        'nilai_akhir' => $nilai?->nilai_akhir,
                    ];
                });

                $dataRapor[] = [
                    'kelas'       => $kelas,
                    'semester'    => $semester,
                    'tahunAjaran' => $tahunAjaran,
                    'nilais'      => $nilaiPerMapel,
                    'rataRata'    => $rataRata,
                    'status'      => $status,
                    'absensi'     => $absensiSummary,
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
