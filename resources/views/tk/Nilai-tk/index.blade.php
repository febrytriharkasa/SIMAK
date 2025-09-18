@extends('layouts.sbadmin')

@section('title', 'Data Nilai Siswa TK')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Nilai TK</h3>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('nilai-tk.create') }}" class="btn btn-primary ms-5">+ Tambah Nilai</a>

        <form action="{{ route('nilai-tk.index') }}" method="GET" class="d-flex align-items-center">
            <label for="kelas_id" class="me-2 mb-0">Filter Kelas:</label>
            <select name="kelas_id" id="kelas_id" class="form-control me-2" style="width:200px;">
                <option value="">-- Semua Kelas --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->id }}" {{ (isset($kelasId) && $kelasId == $k->id) ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswas as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->kelas ? $siswa->kelas->nama_kelas : '-' }}</td>
                            <td>
                                <a href="{{ route('nilai-tk.show', $siswa->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Lihat Nilai
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
