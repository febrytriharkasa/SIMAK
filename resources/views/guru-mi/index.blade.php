@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Guru MI</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('guru-mi.create') }}" class="btn btn-primary">+ Tambah Guru</a>

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
                            <td>{{ $g->mapel }}</td>
                            <td>{{ $g->no_hp_guru }}</td>
                            <td>{{ $g->alamat_guru }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- Edit Card -->
                                    <a href="{{ route('guru-mi.edit', $g->id) }}" class="text-decoration-none">
                                        <div class="card shadow-sm action-card edit-card">
                                            <i class="bi bi-pencil-fill"></i>
                                        </div>
                                    </a>

                                    <!-- Hapus Card -->
                                    <form action="{{ route('guru-mi.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn p-0 border-0" style="background:none;">
                                            <div class="card shadow-sm action-card delete-card">
                                                <i class="bi bi-trash-fill"></i>
                                            </div>
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
            <div class="d-flex justify-content-center">
                {{ $guru->appends(['nip' => request('nip')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
