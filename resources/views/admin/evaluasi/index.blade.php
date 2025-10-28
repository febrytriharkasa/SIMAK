@extends('layouts.sbadmin')

@section('title', 'Evaluasi Kinerja Pegawai/Guru')

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
        <h4 class="fw-bold">Evaluasi Kinerja Pegawai/Guru</h4>
    </div>

    {{-- Form Pencarian --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('evaluasi.create') }}" class="btn btn-primary text-white">
                <i class="bi bi-plus-lg"></i> Tambah Evaluasi
            </a>
            <form method="GET" action="{{ route('evaluasi.index') }}" class="d-flex align-items-center">
                <label for="search" class="me-2 fw-bold mb-0">Cari Nama/NIP:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                    class="form-control me-2" style="max-width:200px;" placeholder="Masukkan kata kunci...">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Evaluasi --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0 text-white">Daftar Evaluasi Kinerja</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Periode</th>
                            <th>Nilai Akhir</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluasi as $key => $e)
                        <tr class="align-middle text-center">
                            <td>{{ $evaluasi->firstItem() + $key }}</td>
                            <td>{{ $e->user->nip ?? '-' }}</td>
                            <td class="text-start">{{ $e->user->name ?? '-' }}</td>
                            <td>{{ $e->periode }}</td>
                            <td>{{ $e->nilai_akhir }}</td>
                            <td>
                                <span class="badge 
                                    @if($e->kategori == 'Sangat Baik') bg-success 
                                    @elseif($e->kategori == 'Baik') bg-primary
                                    @elseif($e->kategori == 'Cukup') bg-warning text-dark
                                    @else bg-danger @endif">
                                    {{ $e->kategori }}
                                </span>
                            </td>
                            <td class="text-start">{{ $e->deskripsi }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('evaluasi.edit', $e->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Tombol Detail --}}
                                    <a href="{{ route('evaluasi.show', $e->id) }}" 
                                       class="btn btn-sm btn-info text-white" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('evaluasi.destroy', $e->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Yakin hapus data ini?')" 
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center p-3">
                                <span class="text-muted">Belum ada data evaluasi.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-3">
                {{ $evaluasi->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
