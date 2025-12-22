<?php

namespace App\Http\Controllers;

use App\Models\AbsensiTK;
use App\Models\SiswaTk;
use App\Models\KelasTk;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AbsensiTKController extends Controller
{
    public function index(Request $request)
    {
        $kelas = KelasTk::orderBy('nama_kelas')->get();
        $absensi = collect();

        if ($request->filled('kelas_id') && $request->filled('tanggal')) {
            $absensi = AbsensiTK::with('siswa.kelas')
                ->whereDate('tanggal', $request->tanggal)
                ->whereHas('siswa', function ($q) use ($request) {
                    $q->where('kelas_id', $request->kelas_id);
                })
                ->orderBy('tanggal')
                ->get();
        }

        return view('tk.absensi-tk.index', compact('kelas', 'absensi'));
    }

    public function create()
    {
        $kelas = KelasTk::where('tingkat', '<', 4)
            ->orderBy('tingkat')
            ->get();
        $siswa = collect(); // KOSONG, BUKAN NULL

        return view('tk.absensi-tk.create', compact('kelas', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'   => 'required|exists:kelas_tk,id',
            'tanggal'    => 'required|date',
            'status'     => 'required|array',
            'status.*'   => 'in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|array'
        ]);

        // Ambil siswa yang benar-benar milik kelas
        $siswaKelas = SiswaTk::where('kelas_id', $request->kelas_id)
            ->pluck('id')
            ->toArray();

        foreach ($request->status as $siswa_id => $status) {

            // skip jika siswa tidak termasuk kelas
            if (!in_array($siswa_id, $siswaKelas)) {
                continue;
            }

            try {
                AbsensiTK::create([
                    'siswa_id'   => $siswa_id,
                    'kelas_id'   => $request->kelas_id,
                    'tanggal'    => $request->tanggal,
                    'status'     => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null
                ]);
            } catch (QueryException $e) {
                // duplikasi absensi (unique siswa + tanggal)
                continue;
            }
        }

        return redirect()
            ->route('absensi-tk.index')
            ->with('success', 'Absensi kelas berhasil disimpan');
    }

    public function edit($id)
    {
        $absensi = AbsensiTK::with('siswa.kelas')->findOrFail($id);

        return view('tk.absensi-tk.edit', compact('absensi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string'
        ]);

        $absensi = AbsensiTK::findOrFail($id);

        $absensi->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('absensi-tk.index')
            ->with('success', 'Absensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $absensi = AbsensiTK::findOrFail($id);
        $absensi->delete();
        return redirect()
            ->route('absensi-tk.index')
            ->with('success', 'Absensi berhasil dihapus');
    }

    public function getSiswaByKelas($kelas_id)
    {
        return SiswaTk::where('kelas_id', $kelas_id)
            ->orderBy('nama')
            ->get();
    }
}

