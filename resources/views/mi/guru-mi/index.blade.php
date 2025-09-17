@extends('layouts.sbadmin')

@section('title', 'Data Guru MI')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Data Guru MI</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('guru-mi.create') }}" class="btn btn-primary ms-5">+ Tambah Guru</a>

        <!-- Form Search -->
        <form action="{{ route('guru-mi.index') }}" method="GET" class="d-flex" style="max-width:300px;">
            <input type="text" name="nip" class="form-control me-2"
                   placeholder="Cari NIP" value="{{ request('nip') }}">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
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
                        <tr>
                            <td>{{ $loop->iteration + ($guru->currentPage()-1) * $guru->perPage() }}</td>
                            <td>{{ $g->nip }}</td>
                            <td>{{ $g->nama }}</td>
                            <td>
                                @if($g->mapels->isNotEmpty())
                                    {{ $g->mapels->pluck('nama_mapel')->join(', ') }}
                                @else
                                    <em>-</em>
                                @endif
                            </td>
                            <td>{{ $g->no_hp_guru }}</td>
                            <td>{{ $g->alamat_guru }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('guru-mi.edit', $g->id) }}" 
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Tombol Show --}}
                                    <a href="{{ route('guru-mi.show', $g->id) }}" 
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('guru-mi.destroy', $g->id) }}"
                                            method="POST" 
                                            onsubmit="return confirm('Yakin hapus data ini?')" 
                                            style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> 
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Belum ada data guru.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $guru->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

