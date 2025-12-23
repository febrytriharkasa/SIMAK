@extends('layouts.sbadmin')

@section('title', 'Detail Siswa MI')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Detail Siswa MI</h5>
                </div>
                <div class="card-body">

                    {{-- Data Siswa --}}
                    <h6 class="mb-3">Data Siswa</h6>
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th width="200">NISN</th>
                            <td>{{ $siswa->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $siswa->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Masuk</th>
                            <td>{{ $siswa->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <td>{{ $siswa->tahunAjaran ? $siswa->tahunAjaran->nama_tahun : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $siswa->kelas ? $siswa->kelas->nama_kelas : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Siswa</th>
                            <td>{{ $siswa->alamat_siswa }}</td>
                        </tr>
                    </table>

                    {{-- Data Wali --}}
                    <h6 class="mb-3">Data Wali</h6>
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th width="200">Nama Wali</th>
                            <td>{{ $siswa->nama_wali }}</td>
                        </tr>
                        <tr>
                            <th>Email Wali</th>
                            <td>{{ $siswa->email }}</td>
                        </tr>
                        <tr>
                            <th>No HP Wali</th>
                            <td>{{ $siswa->no_hp_wali }}</td>
                        </tr>
                    </table>

                    {{-- Data Orang Tua --}}
                    <h6 class="mb-3">Data Orang Tua Kandung</h6>
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th width="200">Nama Ayah</th>
                            <td>{{ $siswa->nama_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Ibu</th>
                            <td>{{ $siswa->nama_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Alamat Orang Tua</th>
                            <td>{{ $siswa->alamat_orangtua ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>No HP Orang Tua</th>
                            <td>{{ $siswa->no_hp_orangtua ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan Ayah</th>
                            <td>{{ $siswa->pekerjaan_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan Ibu</th>
                            <td>{{ $siswa->pekerjaan_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pendidikan Ayah</th>
                            <td>{{ $siswa->pendidikan_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pendidikan Ibu</th>
                            <td>{{ $siswa->pendidikan_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Penghasilan Ayah</th>
                            <td>{{ $siswa->penghasilan_ayah ? 'Rp ' . number_format($siswa->penghasilan_ayah,0,',','.') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Penghasilan Ibu</th>
                            <td>{{ $siswa->penghasilan_ibu ? 'Rp ' . number_format($siswa->penghasilan_ibu,0,',','.') : '-' }}</td>
                        </tr>
                    </table>

                    {{-- Aksi --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('siswa-mi.edit', $siswa->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('siswa-mi.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('siswa-mi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
