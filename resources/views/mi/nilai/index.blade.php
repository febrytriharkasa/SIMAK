@extends('layouts.sbadmin')

@section('title', 'Data Nilai Siswa MI')

@section('content')

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Daftar Nilai Siswa MI</h4>
    </div>

    {{-- Filter Kelas --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('nilai.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Nilai
            </a>
            <form action="{{ route('nilai.index') }}" method="GET" class="d-flex align-items-center">
                <label for="kelas_id" class="me-2 mb-0 fw-bold">Filter Kelas:</label>
                <select name="kelas_id" id="kelas_id" class="form-select me-2" style="width:200px;">
                    <option value="">-- Semua Kelas --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ (isset($kelasId) && $kelasId == $k->id) ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-filter"></i> Tampilkan
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data Siswa --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Nilai MI</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                            <tr class="text-center align-middle">
                                <td>{{ $index + 1 }}</td>

                                {{-- Tambahan NISN --}}
                                <td>{{ $siswa->nisn }}</td>

                                <td class="text-start">{{ $siswa->nama }}</td>

                                <td>
                                    <span class="badge bg-primary">
                                        {{ $siswa->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('nilai.show', $siswa->id) }}"
                                    class="btn btn-sm btn-info text-white"
                                    title="Lihat Nilai">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-3">
                                    <span class="text-muted">Belum ada data siswa untuk kelas ini.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-3">
                {{ $siswas->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
