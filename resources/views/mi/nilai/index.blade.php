@extends('layouts.sbadmin')

@section('title', 'Data Nilai Siswa MI')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Data Nilai Siswa MI</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <!-- Tombol Tambah -->
        <a href="{{ route('nilai.create') }}" class="btn btn-primary ms-5">+ Tambah Nilai</a>

        <!-- Form Filter -->
        <form method="GET" action="{{ route('nilai.index') }}" class="d-flex gap-2 me-5">
            <select name="kelas_id" class="form-select" style="width:200px;">
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelasList as $kelas)
                    <option value="{{ $kelas->id }}" {{ request('kelas_id')==$kelas->id ? 'selected' : '' }}>
                        {{ $kelas->nama_kelas }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-success">Filter</button>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswaList as $index => $siswa)
                        <tr>
                            <td>{{ $siswaList->firstItem() + $index }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td class="text-center">
                                <a href="{{ route('nilai.show', ['siswaId' => $siswa->id, 'kelas_id' => request('kelas_id')]) }}" 
                                   class="btn btn-primary btn-sm">
                                    Lihat Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Belum ada data nilai siswa.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $siswaList->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
