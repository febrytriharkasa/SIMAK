<?php

namespace App\Http\Controllers;

use App\Models\AbsensiTK;
use App\Models\SiswaTk;
use App\Models\KelasTk;
use App\Models\TahunAjaranTk;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use App\Mail\AbsensiTKMail;

class AbsensiTKController extends Controller
{
    public function index(Request $request)
    {
        $kelas = KelasTk::orderBy('nama_kelas')->get();
        $absensi = collect();

        if ($request->filled('kelas_id')) {

            $query = AbsensiTK::with(['siswa.kelas', 'tahunAjaran'])
                ->where('kelas_id', $request->kelas_id);

            // TANGGAL OPSIONAL
            if ($request->filled('tanggal')) {
                $query->whereDate('tanggal', $request->tanggal);
            }

            $absensi = $query
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

        $tahunAjaranAktif = TahunAjaranTk::where('aktif', true)->firstOrFail();

        foreach ($request->status as $siswa_id => $status) {

            $siswa = SiswaTk::find($siswa_id);

            // skip siswa non-aktif
            if (!$siswa || $siswa->status !== 'aktif') {
                continue;
            }

            // skip jika siswa tidak termasuk kelas
            if (!in_array($siswa_id, $siswaKelas)) {
                continue;
            }

            try {
                $absensi = AbsensiTK::create([
                    'siswa_id'        => $siswa_id,
                    'kelas_id'        => $request->kelas_id,
                    'tahun_ajaran_id' => $tahunAjaranAktif->id,
                    'tanggal'         => $request->tanggal,
                    'status'          => $status,
                    'keterangan'      => $request->keterangan[$siswa_id] ?? null
                ]);

                // Kirim email ke wali/siswa
                if ($absensi->siswa->email) {
                    Mail::to($absensi->siswa->email)
                        ->send(new AbsensiTKMail($absensi));
                }
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
            ->where('status', 'aktif') // hanya siswa aktif
            ->orderBy('nama')
            ->get();
    }
}
