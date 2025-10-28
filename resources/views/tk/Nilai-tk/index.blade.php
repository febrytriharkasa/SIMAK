@extends('layouts.sbadmin')

@section('title', 'Data Nilai Siswa TK')

@section('content')

<style>
    /* Light mode */
    [data-bs-theme="light"] #content-wrapper,
    [data-bs-theme="light"] .container {
        background-color: #fff !important;
        color: #181515;
    }
    [data-bs-theme="light"] .card,
    [data-bs-theme="light"] .form-control {
        background-color: #f8f9fa !important;
        color: #000;
    }
    [data-bs-theme="light"] label {
        color: #000;
    }

    /* Dark mode */
    [data-bs-theme="dark"] #content-wrapper,
    [data-bs-theme="dark"] .container {
        background-color: #1B1B1DFF !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .form-control {
        background-color: #2c2c2e !important;
        color: #fff;
        border: 1px solid #444;
    }
    [data-bs-theme="dark"] label {
        color: #fff;
    }
</style>

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Nilai Siswa TK</h4>
    </div>

    {{-- Filter Kelas --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            {{-- Tombol Tambah Nilai --}}
            <a href="{{ route('nilai-tk.create') }}" class="btn btn-primary">
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

    {{-- Tabel Data Nilai --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Nilai TK</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $siswa)
                            <tr class="align-middle text-center">
                                <td>{{ $loop->iteration + ($siswas->currentPage()-1) * $siswas->perPage() }}</td>
                                <td class="text-start">{{ $siswa->nama }}</td>
                                <td>
                                    @if($siswa->kelas)
                                        <span class="badge bg-info text-dark">{{ $siswa->kelas->nama_kelas }}</span>
                                    @else
                                        <em class="text-muted">-</em>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('nilai-tk.show', $siswa->id) }}" 
                                       class="btn btn-sm btn-info text-white" title="Lihat Nilai">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-3">
                                    <span class="text-muted">Belum ada data nilai siswa.</span>
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
