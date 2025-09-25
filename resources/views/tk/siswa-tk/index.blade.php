@extends('layouts.sbadmin')

@section('title', 'Data Siswa TK')

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
            <h3 class="ms-2">👩‍🎓 Data Siswa TK</h3>

            <a href="{{ route('siswa-tk.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Tambah Siswa
            </a>
        </div>

        {{-- ===================== Pencarian ===================== --}}
        <form action="{{ route('siswa-tk.index') }}" method="GET" class="d-flex mb-3" style="max-width:350px;">
            <input type="text" name="search" value="{{ request('search') }}" 
                class="form-control me-2" placeholder="🔍 Cari No Induk / Nama...">
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
                                <th>No Induk</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Tahun</th>
                                <th>Nama Wali</th>
                                <th>No HP Wali</th>
                                <th>Alamat</th>
                                <th style="width: 160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswa as $row)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + ($siswa->currentPage()-1) * $siswa->perPage() }}</td>
                                    <td>{{ $row->id_tk }}</td>
                                    <td>{{ $row->nama }}</td>
                                    <td>{{ $row->kelas->nama_kelas ?? '-' }}</td>
                                    <td>{{ $row->tahun }}</td>
                                    <td>{{ $row->nama_wali }}</td>
                                    <td>{{ $row->no_hp_wali }}</td>
                                    <td>{{ $row->alamat_siswa }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Edit --}}
                                            <a href="{{ route('siswa-tk.edit', $row->id) }}" 
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            {{-- Show --}}
                                            <a href="{{ route('siswa-tk.show', $row->id) }}" 
                                                class="btn btn-sm btn-info text-white" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            {{-- Hapus --}}
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
                                    <td colspan="9" class="text-center text-muted">📭 Belum ada data siswa.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-3">
                    {{ $siswa->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
