<?php

namespace App\Http\Controllers;

use App\Models\NilaiMi;
use App\Models\Siswa_MI;
use App\Models\MapelMi;
use App\Models\Guru_MI;
use App\Models\Kelas_MI;
use App\Models\AbsensiMI;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\TahunAjaranMI;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NilaiMiController extends Controller
{
    // Menampilkan daftar nilai
    public function index(Request $request)
    {
        $kelasList = Kelas_MI::orderBy('tingkat')->get();
        $kelasId = $request->kelas_id;

        $siswas = Siswa_MI::with([
            'kelas',
            'nilais.tahunAjaran'
        ])
            ->where('status', 'aktif')
            ->when($kelasId, fn($q) => $q->where('kelas_id', $kelasId))
            ->paginate(10);

        return view('mi.nilai.index', compact('siswas', 'kelasList', 'kelasId'));
    }



    // Menampilkan form tambah nilai
    public function create()
    {
        // Ambil semua kelas beserta siswa
        $kelasList = Kelas_MI::where('tingkat', '<', 7)
            ->orderBy('tingkat')
            ->get();

        // Ambil semua mapel beserta guru
        $mapelList = MapelMi::with('guru')->get();

        return view('mi.nilai.create', compact('kelasList', 'mapelList'));
    }


    // Menyimpan data nilai baru
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas_mi,id',
            'mapel_id' => 'required|exists:mapel_mi,id',
            'semester' => 'required|in:ganjil,genap',
            'nilai'    => 'required|array',
        ]);

        $tahunAjaranAktif = TahunAjaranMI::where('aktif', true)->firstOrFail();

        foreach ($request->nilai as $siswaId => $data) {

            // Ambil siswa
            $siswa = Siswa_MI::find($siswaId);

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

            $exists = NilaiMi::where([
                'siswa_id'        => $siswaId,
                'mapel_id'        => $request->mapel_id,
                'kelas_id'        => $request->kelas_id,
                'semester'        => $request->semester,
                'tahun_ajaran_id' => $tahunAjaranAktif->id,
            ])->exists();

            if ($exists) continue;

            $rataTugas = array_sum($tugas) / count($tugas);
            $nilaiAkhir = ($rataTugas * 0.3) + ($uts * 0.35) + ($eas * 0.35);

            NilaiMi::create([
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

        return redirect()->route('nilai.index')
            ->with('success', 'Data nilai berhasil disimpan.');
    }


    // Menampilkan form edit nilai
    public function edit(NilaiMi $nilai)
    {
        $siswa = Siswa_MI::all();
        $mapel = MapelMi::all();
        $guru = Guru_MI::all();
        $kelas = Kelas_MI::all();
        return view('mi.nilai.edit', compact('nilai', 'siswa', 'mapel', 'guru', 'kelas'));
    }

    // Mengupdate data nilai
    public function update(Request $request, NilaiMi $nilai)
    {
        // Konversi string tugas menjadi array
        if (is_string($request->tugas)) {
            $request->merge([
                'tugas' => array_map('trim', explode(',', $request->tugas))
            ]);
        }

        $request->validate([
            'siswa_id' => 'required|exists:siswas_mi,id',
            'mapel_id' => 'required|exists:mapel_mi,id',
            'kelas_id' => 'required|exists:kelas_mi,id',
            'tugas'    => 'required|array',
            'uts'      => 'required|numeric|min:0|max:100',
            'eas'      => 'required|numeric|min:0|max:100',
        ]);

        // Hitung nilai_akhir otomatis
        $rataTugas = array_sum($request->tugas) / count($request->tugas);
        $nilaiAkhir = ($rataTugas * 0.3) + ($request->uts * 0.35) + ($request->eas * 0.35);

        $nilai->update(array_merge($request->all(), [
            'nilai_akhir' => round($nilaiAkhir)
        ]));

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil diperbarui!');
    }


    // Menghapus data nilai
    public function destroy(NilaiMi $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus!');
    }

    public function show($id, Request $request)
    {
        $siswa = Siswa_MI::with('kelas')->findOrFail($id);

        // kelas aktif (default = kelas siswa sekarang)
        $kelasId = $request->kelas_id ?? $siswa->kelas_id;

        // semester (opsional)
        $semester = $request->semester; // ganjil | genap | null

        // ambil nilai berdasarkan siswa + kelas + semester (jika ada)
        $nilais = NilaiMi::with('mapel')
            ->where('siswa_id', $siswa->id)
            ->where('kelas_id', $kelasId)
            ->when($semester, function ($q) use ($semester) {
                $q->where('semester', $semester);
            })
            ->orderBy('semester')
            ->orderBy('mapel_id')
            ->get();

        $kelasList = Kelas_MI::orderBy('tingkat')->get();

        return view('mi.nilai.show', compact(
            'siswa',
            'nilais',
            'kelasList',
            'kelasId',
            'semester'
        ));
    }

    public function cetakRaporPdfAllKelas($siswaId)
    {
        $siswa = Siswa_MI::with(['kelas', 'absensis'])->findOrFail($siswaId);

        $kelasList = Kelas_MI::where('tingkat', '<=', $siswa->kelas->tingkat)
            ->orderBy('tingkat')
            ->get();

        $mapels = MapelMi::orderBy('nama_mapel')->get();

        $dataRapor = [];

        foreach ($kelasList as $kelas) {
            foreach (['ganjil', 'genap'] as $semester) {

                // AMBIL NILAI
                $nilais = NilaiMi::with(['mapel', 'tahunAjaran'])
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


        $pdf = Pdf::loadView('mi.nilai.rapor-pdf', [
            'siswa' => $siswa,
            'dataRapor' => $dataRapor,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream('Rapor_' . $siswa->nama . '.pdf');
    }
}
