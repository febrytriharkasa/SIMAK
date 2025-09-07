@extends('layouts.sbadmin')

@section('title', 'Detail Siswa MI')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Detail Siswa MI</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">NISN</th>
                            <td>{{ $siswa->nisn }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $siswa->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $siswa->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $siswa->kelas ? $siswa->kelas->nama_kelas : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama Wali</th>
                            <td>{{ $siswa->nama_wali }}</td>
                        </tr>
                        <tr>
                            <th>No HP Wali</th>
                            <td>{{ $siswa->no_hp_wali }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $siswa->alamat_siswa }}</td>
                        </tr>
                    </table>

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
