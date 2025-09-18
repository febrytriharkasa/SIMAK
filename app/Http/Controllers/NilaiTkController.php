<?php

namespace App\Http\Controllers;

use App\Models\NilaiTk;
use App\Models\SiswaTk;
use App\Models\MapelTk;
use App\Models\GuruTk;
use App\Models\KelasTk;
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

        $siswas = $query->get();

        return view('tk.nilai-tk.index', compact('siswas', 'kelasList', 'kelasId'));
    }

    // Menampilkan form tambah nilai
   public function create()
    {
        // Ambil semua kelas beserta siswa
        $kelasList = KelasTk::with('siswas')->get();

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
            'guru_id'  => 'required|exists:guru_tk,id',
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

            // Hitung nilai_akhir otomatis
            $rataTugas = array_sum($tugas) / count($tugas);
            $nilaiAkhir = ($rataTugas * 0.3) + ($uts * 0.35) + ($eas * 0.35);

            // Simpan ke database
            NilaiTk::create([
                'siswa_id'    => $siswaId,
                'mapel_id'    => $request->mapel_id,
                'guru_id'     => $request->guru_id,
                'kelas_id'    => $request->kelas_id,
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
            'guru_id'  => 'required|exists:guru_tk,id',
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

        app()->make(\App\Http\Controllers\SiswaTkController::class)->naikKelasTk();

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

        // Jika ada request kelas_id, pakai itu; jika tidak, pakai kelas siswa saat ini
        $kelasId = $request->kelas_id ?? $siswa->kelas_id;

        // Ambil nilai siswa hanya untuk kelas yang dipilih
        $nilais = NilaiTk::with('mapel', 'guru')
            ->where('siswa_id', $siswa->id)
            ->where('kelas_id', $kelasId)
            ->get();

        // Ambil daftar kelas siswa untuk dropdown (optional)
        $kelasList = KelasTk::all();

        return view('tk.nilai-tk.show', compact('siswa', 'nilais', 'kelasList', 'kelasId'));
    }


}
