<?php

namespace App\Http\Controllers;

use App\Models\AbsensiMI;
use App\Models\Siswa_MI;
use App\Models\Kelas_Mi;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AbsensiMIController extends Controller
{
    /**
     * Tampilkan daftar absensi
     */
    public function index(Request $request)
    {
        $kelas = Kelas_Mi::orderBy('nama_kelas')->get();
        $absensi = collect(); // default kosong

        if ($request->filled('kelas_id') && $request->filled('tanggal')) {
            $absensi = AbsensiMI::with(['siswa.kelas'])
                ->whereDate('tanggal', $request->tanggal)
                ->whereHas('siswa', function ($q) use ($request) {
                    $q->where('kelas_id', $request->kelas_id);
                })
                ->orderBy('tanggal')
                ->get();
        }

        return view('mi.absensi-mi.index', compact('kelas', 'absensi'));
    }

    /**
     * Form absensi per kelas
     */
    public function create()
    {
        $kelas = Kelas_Mi::where('tingkat', '<', 7)
            ->orderBy('tingkat')
            ->get();

        $siswa = collect(); // KOSONG, BUKAN NULL

        return view('mi.absensi-mi.create', compact('kelas', 'siswa'));
    }

    /**
     * Simpan absensi per kelas (massal)
     */
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'   => 'required|exists:kelas_mi,id',
            'tanggal'    => 'required|date',
            'status'     => 'required|array',
            'status.*'   => 'in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|array'
        ]);
         

        // Ambil siswa yang benar-benar milik kelas tersebut
        $siswaKelas = Siswa_MI::where('kelas_id', $request->kelas_id)
            ->pluck('id')
            ->toArray();

        foreach ($request->status as $siswa_id => $status) {

            // Skip jika siswa bukan anggota kelas
            if (!in_array($siswa_id, $siswaKelas)) {
                continue;
            }

            try {
                AbsensiMI::create([
                    'siswa_id'   => $siswa_id,
                    'kelas_id'   => $request->kelas_id,
                    'tanggal'    => $request->tanggal,
                    'status'     => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null
                ]);
            } catch (QueryException $e) {
                // Skip duplikasi (unique siswa + tanggal)
                continue;
            }
        }

        return redirect()
            ->route('absensi-mi.index')
            ->with('success', 'Absensi kelas berhasil disimpan');
    }

    
    public function edit($id)
    {
        $absensi = AbsensiMI::with('siswa.kelas')->findOrFail($id);

        return view('mi.absensi-mi.edit', compact('absensi'));
    }

    public function update(Request $request, $id)
    {
        $absensi = AbsensiMI::findOrFail($id);

        $request->validate([
            'status'     => 'required|in:hadir,izin,sakit,alfa',
            'keterangan' => 'nullable|string'
        ]);

        $absensi->update([
            'status'     => $request->status,
            'keterangan' => $request->keterangan
        ]);

        return redirect()
            ->route('absensi-mi.index')
            ->with('success', 'Absensi berhasil diperbarui');
    }

    /**
     * Hapus absensi
     */
    public function destroy($id)
    {
        AbsensiMI::findOrFail($id)->delete();

        return redirect()
            ->route('absensi-mi.index')
            ->with('success', 'Absensi berhasil dihapus');
    }

    public function getSiswaByKelas($kelas_id)
    {
        return Siswa_MI::where('kelas_id', $kelas_id)
            ->orderBy('nama')
            ->get();
    }
}
