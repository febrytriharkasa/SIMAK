<?php

namespace App\Http\Controllers;

use App\Models\NilaiMi;
use App\Models\Siswa_MI;
use App\Models\MapelMi;
use App\Models\Kelas_MI;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NilaiMiController extends Controller
{
    // Index: menampilkan siswa berdasarkan kelas nilai
    public function index(Request $request)
    {
        $kelasList = Kelas_Mi::all();
        $siswaList = collect();

        if ($request->filled('kelas_id')) {
            $siswaList = NilaiMi::with('siswa')
                ->where('kelas_id', $request->kelas_id)
                ->get()
                ->pluck('siswa')
                ->unique('id')
                ->values();
        }

        // Paginate manual
        $perPage = 10;
        $page = $request->get('page', 1);
        $sliced = $siswaList->slice(($page - 1) * $perPage, $perPage)->values();

        $siswaList = new LengthAwarePaginator(
            $sliced,
            $siswaList->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('mi.nilai.index', compact('siswaList', 'kelasList'));
    }

    public function create()
    {
        $kelasList = Kelas_Mi::with('siswas')->get();
        $mapelList = MapelMi::with('guru')->get();

        return view('mi.nilai.create', compact('kelasList', 'mapelList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'  => 'required|exists:kelas_mi,id',
            'mapel_id'  => 'required|exists:mapel_mi,id',
            'guru_id'  => 'required|exists:gurus_mi,id', // tambah validasi guru
            'nilai'     => 'required|array', // format: [siswa_id => ['tugas'=>[], 'uts'=>, 'uas'=>]]
        ]);

        $mapel  = MapelMi::with('guru')->findOrFail($request->mapel_id);
        $guruId = $request->guru_id;

        foreach ($request->nilai as $siswaId => $data) {
            $siswa = Siswa_MI::findOrFail($siswaId);

            // Cek apakah sudah ada nilai untuk siswa ini di mapel & kelas
            $cek = NilaiMi::where('siswa_id', $siswaId)
                ->where('mapel_id', $mapel->id)
                ->where('kelas_id', $request->kelas_id)
                ->first();

            if ($cek) {
                continue; // skip jika sudah ada
            }

            $tugas = array_map('intval', $data['tugas'] ?? []);
            $rataTugas = count($tugas) ? array_sum($tugas) / count($tugas) : 0;

            $nilaiAkhir = ($rataTugas * 0.4) + (($data['uts'] ?? 0) * 0.3) + (($data['uas'] ?? 0) * 0.3);

            NilaiMi::create([
                'siswa_id'    => $siswaId,
                'guru_id'     => $guruId,
                'mapel_id'    => $mapel->id,
                'kelas_id'    => $request->kelas_id,
                'tugas'       => $tugas,
                'uts'         => $data['uts'] ?? 0,
                'eas'         => $data['uas'] ?? 0,
                'nilai_akhir' => $nilaiAkhir,
            ]);
        }

        return redirect()->route('nilai.index')->with('success','Nilai berhasil ditambahkan');
    }

    public function edit(NilaiMi $nilai)
    {
        $mapelList = MapelMi::with('guru')->get();
        return view('mi.nilai.edit', compact('nilai','mapelList'));
    }

    public function update(Request $request, NilaiMi $nilai)
    {
        $request->validate([
            'mapel_id' => 'required|exists:mapel_mi,id',
            'siswa_id' => 'required|exists:siswas_mi,id',
            'guru_id'  => 'required|exists:gurus_mi,id', // tambah validasi guru
        ]);

        $siswa   = Siswa_MI::findOrFail($request->siswa_id);
        $kelasId = $siswa->kelas_id;

        $mapel  = MapelMi::with('guru')->findOrFail($request->mapel_id);
        $guruId = $mapel->guru->id ?? null;

        // Cek duplikat (selain data ini sendiri)
        $cek = NilaiMi::where('siswa_id', $siswa->id)
            ->where('mapel_id', $mapel->id)
            ->where('kelas_id', $kelasId)
            ->where('id', '!=', $nilai->id)
            ->first();

        if ($cek) {
            return redirect()->back()
                ->withErrors(['mapel_id' => 'Nilai untuk mapel ini sudah ada di kelas ini'])
                ->withInput();
        }

        $tugas = array_map('intval', $request->tugas ?? []);
        $rataTugas = count($tugas) ? array_sum($tugas) / count($tugas) : 0;

        $nilaiAkhir = ($rataTugas * 0.4) + (($request->uts ?? 0) * 0.3) + (($request->uas ?? 0) * 0.3);

        $nilai->update([
            'siswa_id'    => $siswa->id,
            'guru_id'     => $guruId,
            'mapel_id'    => $mapel->id,
            'kelas_id'    => $kelasId,
            'tugas'       => $tugas,
            'uts'         => $request->uts ?? 0,
            'eas'         => $request->uas ?? 0,
            'nilai_akhir' => $nilaiAkhir,
        ]);

        return redirect()->route('nilai.index')->with('success','Nilai berhasil diperbarui');
    }

    public function destroy(NilaiMi $nilai)
    {
        $nilai->delete();
        return redirect()->route('nilai.index')->with('success','Nilai berhasil dihapus');
    }

    
    // Show: menampilkan nilai siswa sesuai kelas
    public function show(Request $request, $siswaId)
    {
        $query = NilaiMi::with(['mapel', 'guru', 'kelas', 'siswa'])
            ->where('siswa_id', $siswaId);

        // Filter berdasarkan kelas_id dari query string
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $nilaiSiswa = $query->get();

        return view('mi.nilai.show', compact('nilaiSiswa'));
    }


}