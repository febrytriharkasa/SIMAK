@extends('layouts.sbadmin')

@section('title', 'Data Guru TK')

@section('content')
    {{-- ===================== CSS Custom (Light & Dark Mode) ===================== --}}
    <style>
        /* Light mode */
        [data-bs-theme="light"] #content-wrapper,
        [data-bs-theme="light"] .container-fluid {
            background-color: #fff !important;
            color: #181515;
        }
        [data-bs-theme="light"] .table thead {
            background-color: #f8f9fa;
            color: #000;
        }

        /* Dark mode */
        [data-bs-theme="dark"] #content-wrapper,
        [data-bs-theme="dark"] .container-fluid {
            background-color: #1B1B1DFF !important;
            color: #fff;
        }
        [data-bs-theme="dark"] .table thead {
            background-color: #2c2c2e;
            color: #fff;
        }
    </style>

    <div class="container-fluid">
        {{-- ===================== Heading & Action Button ===================== --}}
        <div class="page-heading mb-4 d-flex align-items-center justify-content-between">
            <h3 class="ms-2">🏫 Data Guru TK</h3>

            <a href="{{ route('guru-tk.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Guru
            </a>
        </div>

        {{-- ===================== Pencarian ===================== --}}
        <form action="{{ route('guru-tk.index') }}" method="GET" class="d-flex mb-3" style="max-width:350px;">
            <input type="text" name="nip" value="{{ request('nip') }}" 
                class="form-control me-2" placeholder="🔍 Cari NIP atau Nama...">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>

        {{-- ===================== Alert Success ===================== --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ===================== Tabel Data ===================== --}}
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Mata Pelajaran</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($guru as $g)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ($guru->currentPage()-1) * $guru->perPage() }}</td>
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
                                            {{-- Edit --}}
                                            <a href="{{ route('guru-tk.edit', $g->id) }}" 
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Show --}}
                                            <a href="{{ route('guru-tk.show', $g->id) }}" 
                                                class="btn btn-sm btn-info text-white" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('guru-tk.destroy', $g->id) }}" 
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
                                    <td colspan="7" class="text-center text-muted">📭 Belum ada data guru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $guru->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
