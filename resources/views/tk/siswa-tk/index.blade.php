@extends('layouts.sbadmin')

@section('title', 'Data Siswa TK')

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
        <h4 class="fw-bold">Data Siswa TK</h4>
    </div>

    {{-- Form Pencarian --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('siswa-tk.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Siswa
            </a>
            <form method="GET" action="{{ route('siswa-tk.index') }}" class="d-flex align-items-center">
                <label for="search" class="me-2 fw-bold mb-0">Cari No Induk:</label>
                <input type="text" name="search" id="search" 
                       value="{{ request('search') }}" 
                       class="form-control me-2" placeholder="Masukkan No Induk Siswa" style="max-width:200px;">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data Siswa --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Siswa TK</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>No Induk</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tahun</th>
                            <th>Nama Wali</th>
                            <th>No HP Wali</th>
                            <th>Alamat</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $row)
                            <tr class="align-middle text-center">
                                <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                                <td>{{ $row->id_tk }}</td>
                                <td class="text-start">{{ $row->nama }}</td>
                                <td>
                                    @if($row->kelas)
                                        <span class="badge bg-info text-dark">{{ $row->kelas->nama_kelas }}</span>
                                    @else
                                        <em class="text-muted">-</em>
                                    @endif
                                </td>
                                <td>{{ $row->tahun }}</td>
                                <td>{{ $row->nama_wali }}</td>
                                <td>{{ $row->no_hp_wali }}</td>
                                <td class="text-start">{{ $row->alamat_siswa }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('siswa-tk.edit', $row->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Show --}}
                                        <a href="{{ route('siswa-tk.show', $row->id) }}" 
                                           class="btn btn-sm btn-info text-white" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('siswa-tk.destroy', $row->id) }}" 
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
                                <td colspan="9" class="text-center p-3">
                                    <span class="text-muted">Belum ada data siswa.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-3">
                {{ $siswa->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
