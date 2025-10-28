@extends('layouts.sbadmin')

@section('title', 'Data Guru TK')

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
        <h4 class="fw-bold">Data Guru TK</h4>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Form Pencarian --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('guru-tk.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Guru
            </a>
            <form action="{{ route('guru-tk.index') }}" method="GET" class="d-flex align-items-center">
                <label for="nip" class="me-2 fw-bold mb-0">Cari NIP:</label>
                <input type="text" name="nip" id="nip" class="form-control me-2" 
                       placeholder="Masukkan NIP" value="{{ request('nip') }}" style="max-width:200px;">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data Guru --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Guru TK</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Mata Pelajaran</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th style="width:150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($guru as $g)
                            <tr class="align-middle text-center">
                                <td>{{ $loop->iteration + ($guru->currentPage()-1) * $guru->perPage() }}</td>
                                <td>{{ $g->nip }}</td>
                                <td class="text-start">{{ $g->nama }}</td>
                                <td class="text-start">
                                    @if($g->mapels->isNotEmpty())
                                        @foreach($g->mapels as $m)
                                            <span class="badge bg-info text-dark">{{ $m->nama_mapel }}</span>
                                        @endforeach
                                    @else
                                        <em class="text-muted">-</em>
                                    @endif
                                </td>
                                <td>{{ $g->no_hp_guru }}</td>
                                <td class="text-start">{{ $g->alamat_guru }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('guru-tk.edit', $g->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        {{-- Tombol Show --}}
                                        <a href="{{ route('guru-tk.show', $g->id) }}" 
                                           class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('guru-tk.destroy', $g->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Yakin hapus data ini?')" 
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-3">
                                    <span class="text-muted">Belum ada data guru.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-3">
                {{ $guru->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
