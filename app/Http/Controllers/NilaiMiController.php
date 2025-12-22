<?php

namespace App\Http\Controllers;

use App\Models\NilaiMi;
use App\Models\Siswa_MI;
use App\Models\MapelMi;
use App\Models\Guru_MI;
use App\Models\Kelas_MI;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class NilaiMiController extends Controller
{
    // Menampilkan daftar nilai
    public function index(Request $request)
    {
        // Ambil semua kelas untuk dropdown filter
        $kelasList = Kelas_MI::all();

        // Ambil parameter filter kelas dari request
        $kelasId = $request->kelas_id;

        // Query siswa, filter berdasarkan kelas jika dipilih
        $query = Siswa_MI::with('kelas');

        if ($kelasId) {
            $query->where('kelas_id', $kelasId);
        }

        $siswas = $query->paginate(10);

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

            $exists = NilaiMi::where([
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
            NilaiMi::create([
                'siswa_id'    => $siswaId,
                'mapel_id'    => $request->mapel_id,
                'kelas_id'    => $request->kelas_id,
                'semester'    => $request->semester,
                'tugas'       => $tugas,
                'uts'         => $uts,
                'eas'         => $eas,
                'nilai_akhir' => round($nilaiAkhir),
            ]);
        }

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil ditambahkan!');
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

   public function cetakRaporPdf($siswaId, $kelasId, $semester)
    {
        if (!in_array($semester, ['ganjil', 'genap'])) {
            abort(400, 'Semester tidak valid');
        }

        $siswa = Siswa_MI::with('kelas')->findOrFail($siswaId);

        // ambil semua mapel
        $mapels = MapelMi::orderBy('nama_mapel')->get();

        // ambil nilai SESUAI kelas yg dipilih
        $nilais = NilaiMi::with('mapel')
            ->where('siswa_id', $siswaId)
            ->where('kelas_id', $kelasId)
            ->where('semester', $semester)
            ->get();

        $rataRata = $nilais->count() > 0
            ? round($nilais->avg('nilai_akhir'), 2)
            : 0;

        $status = '-';
        if ($semester === 'genap' && $nilais->count() > 0) {
            $status = $rataRata >= 70 ? 'NAIK KELAS' : 'TINGGAL KELAS';
        }

        $kelas = Kelas_MI::findOrFail($kelasId);

        $pdf = Pdf::loadView('mi.nilai.rapor-pdf', [
            'siswa'    => $siswa,
            'kelas'    => $kelas,
            'mapels'   => $mapels,
            'nilais'   => $nilais,
            'semester' => $semester,
            'rataRata' => $rataRata,
            'status'   => $status,
        ])->setPaper('A4', 'portrait');

        return $pdf->stream(
            'Rapor_' . $siswa->nama . '_' . $kelas->nama_kelas . '_' . strtoupper($semester) . '.pdf'
        );
    }


}
