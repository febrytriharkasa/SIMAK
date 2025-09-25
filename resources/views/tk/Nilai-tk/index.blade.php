@extends('layouts.sbadmin')

@section('title', 'Data Nilai Siswa TK')

@section('content')
{{-- ===================== CSS Custom (Light & Dark Mode) ===================== --}}
<style>
    /* Light mode */
    [data-bs-theme="light"] #content-wrapper,
    [data-bs-theme="light"] .container-fluid {
        background-color: #fff !important;
        color: #181515;
    }
    [data-bs-theme="light"] .card {
        background-color: #f8f9fa !important;
        color: #000;
    }
    [data-bs-theme="light"] .table thead {
        background-color: #e9ecef;
        color: #000;
    }

    /* Dark mode */
    [data-bs-theme="dark"] #content-wrapper,
    [data-bs-theme="dark"] .container-fluid {
        background-color: #1B1B1DFF !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .card {
        background-color: #2c2c2e !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .table thead {
        background-color: #3a3a3c;
        color: #fff;
    }
</style>

<div class="container-fluid p-3 rounded-3">
    {{-- ===================== Heading & Action Button ===================== --}}
    <div class="page-heading mb-4 d-flex align-items-center justify-content-between">
        <h3 class="ms-2">📊 Nilai TK</h3>
            <a href="{{ route('nilai-tk.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Tambah Nilai
            </a>
    </div>

    {{-- ===================== Filter Kelas ===================== --}}
    <form action="{{ route('nilai-tk.index') }}" method="GET" class="d-flex mb-3 align-items-center">
        <label for="kelas_id" class="me-2 mb-0">Filter Kelas:</label>
        <select name="kelas_id" id="kelas_id" class="form-control me-2" style="width:200px;">
            <option value="">-- Semua Kelas --</option>
            @foreach($kelasList as $k)
                <option value="{{ $k->id }}" {{ (isset($kelasId) && $kelasId == $k->id) ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-secondary">Filter</button>
    </form>

    {{-- ===================== Tabel Nilai ===================== --}}
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $siswa)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $siswa->nama }}</td>
                                <td>{{ $siswa->kelas ? $siswa->kelas->nama_kelas : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('nilai-tk.show', $siswa->id) }}" class="btn btn-info btn-sm text-white">
                                        <i class="bi bi-eye"></i> Lihat Nilai
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">📭 Belum ada data nilai siswa.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
