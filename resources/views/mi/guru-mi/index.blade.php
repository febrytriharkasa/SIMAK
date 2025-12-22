@extends('layouts.sbadmin')

@section('title', 'Data Guru MI')

@section('content')

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Data Guru MI</h4>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Filter / Search --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="{{ route('guru-mi.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Guru
            </a>
            <form action="{{ route('guru-mi.index') }}" method="GET" class="d-flex align-items-center">
                <label for="nip" class="me-2 fw-bold mb-0">Cari NIP:</label>
                <input type="text" name="nip" id="nip" 
                       class="form-control me-2" style="max-width:200px;"
                       placeholder="Masukkan NIP" value="{{ request('nip') }}">
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-search"></i> Cari
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Data Guru --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Guru</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Mata Pelajaran</th>
                            <th>No HP</th>
                            <th>Alamat</th>
                            <th style="width: 150px;">Aksi</th>
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
                                        @foreach($g->mapels as $mapel)
                                            <span class="badge bg-info text-dark">{{ $mapel->nama_mapel }}</span>
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
                                        <a href="{{ route('guru-mi.edit', $g->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                           <i class="fas fa-edit"></i>
                                        </a>

                                        {{-- Tombol Show --}}
                                        <a href="{{ route('guru-mi.show', $g->id) }}" 
                                           class="btn btn-sm btn-info text-black" title="Detail">
                                           <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('guru-mi.destroy', $g->id) }}"
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
