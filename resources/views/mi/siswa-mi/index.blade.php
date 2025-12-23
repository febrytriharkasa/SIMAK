@extends('layouts.sbadmin')

@section('title', 'Data Siswa MI')

@section('content')

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Data Siswa MI</h4>
    </div>

    {{-- Form Pencarian --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('siswa-mi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Siswa
            </a>
            <form method="GET" action="{{ route('siswa-mi.index') }}" class="d-flex align-items-center">
                <label for="search" class="me-2 fw-bold mb-0">Cari NISN:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       class="form-control me-2" style="max-width:200px;" placeholder="Masukkan NISN...">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data Siswa --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Siswa</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tahun Masuk</th>
                            <th>Nama Wali</th>
                            <th>Email Wali</th>
                            <th>No HP Wali</th>
                            <th>Alamat</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $row)
                        <tr class="align-middle text-center">
                            <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                            <td>{{ $row->nisn }}</td>
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
                            <td>{{ $row->email_wali }}</td>
                            <td>{{ $row->no_hp_wali }}</td>
                            <td class="text-start">{{ $row->alamat_siswa }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('siswa-mi.edit', $row->id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Tombol Show --}}
                                    <a href="{{ route('siswa-mi.show', $row->id) }}" 
                                       class="btn btn-sm btn-info text-white" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('siswa-mi.destroy', $row->id) }}" 
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
                            <td colspan="10" class="text-center p-3">
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
