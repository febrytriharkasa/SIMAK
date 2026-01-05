@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-5 text-gray-800" style="margin-left: 20px;">Dashboard Orang Tua</h1>

    @if($siswa)
    <!-- Data Siswa Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            Data Siswa
        </div>
        <div class="card-body d-flex flex-wrap" style="gap:20px; align-items:flex-start;">
            <!-- Kiri: Data Siswa (Tabel) -->
            <div style="flex:1; min-width:300px;">
                <table class="table table-borderless table-sm mb-0">
                    <tbody>
                        <tr>
                            <th style="width:160px;">Nama</th>
                            <td>{{ $siswa->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>{{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>{{ $siswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $siswa->kelas?->nama_kelas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <td>{{ $siswa->tahunAjaran?->tahun_ajaran ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $siswa->alamat_siswa }}</td>
                        </tr>
                        <tr>
                            <th>Nama Ayah</th>
                            <td>{{ $siswa->nama_ayah }}</td>
                        </tr>
                        <tr>
                            <th>Nama Ibu</th>
                            <td>{{ $siswa->nama_ibu }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Kanan: Foto Siswa (di luar tabel) -->
            <div style="width:200px; text-align:center;">
                @if($siswa->foto_siswa)
                    <img src="{{ asset('storage/' . $siswa->foto_siswa) }}" 
                         alt="Foto Siswa" 
                         style="width:200px; height:auto; border-radius:8px; border:1px solid #ccc;">
                    <p style="font-size:12px; color:#6c757d; margin-top:5px;">Klik foto untuk upload/hapus</p>
                @else
                    <span class="text-muted">Belum ada foto</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Absensi Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Absensi
        </div>
        <div class="card-body">
            @if($siswa->absensis->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa->absensis as $absen)
                            <tr>
                                <td>{{ $absen->tanggal }}</td>
                                <td>{{ $absen->keterangan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Belum ada data absensi.</p>
            @endif
        </div>
    </div>

    <!-- Nilai Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-white">
            Nilai
        </div>
        <div class="card-body">
            @if($siswa->nilais && $siswa->nilais->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Mata Pelajaran</th>
                                <th>Tugas</th>
                                <th>UTS</th>
                                <th>EAS</th>
                                <th>Nilai Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($siswa->nilais as $nilai)
                            <tr>
                                <td>{{ $nilai->mapel?->nama_mapel ?? '-' }}</td>
                                <td>{{ is_array($nilai->tugas) ? implode(', ', $nilai->tugas) : $nilai->tugas }}</td>
                                <td>{{ $nilai->uts }}</td>
                                <td>{{ $nilai->eas }}</td>
                                <td>{{ $nilai->nilai_akhir }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Belum ada nilai yang tercatat.</p>
            @endif
        </div>
    </div>

    @else
        <p class="text-muted">Data siswa belum tersedia.</p>
    @endif

</div>
@endsection
