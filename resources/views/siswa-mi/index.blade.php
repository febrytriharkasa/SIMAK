@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Siswa MI</h1>

    {{-- Baris atas: tombol tambah + form search --}}
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('siswa-mi.create') }}" class="btn btn-primary">+ Tambah Siswa</a>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('siswa-mi.index') }}" class="form-inline">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" 
                    placeholder="Cari NISN...">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Tahun</th>
                        <th>Nama Wali</th>
                        <th>No HP Wali</th>
                        <th>Alamat</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $row)
                    <tr>
                        <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                        <td>{{ $row->nisn }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->tahun }}</td>
                        <td>{{ $row->nama_wali }}</td>
                        <td>{{ $row->no_hp_wali }}</td>
                        <td>{{ $row->alamat_siswa }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <!-- Edit Card -->
                                <a href="{{ route('siswa-mi.edit', $row->id) }}" class="text-decoration-none">
                                    <div class="card shadow-sm action-card edit-card">
                                        <i class="bi bi-pencil-fill"></i>
                                    </div>
                                </a>

                                <!-- Hapus Card -->
                                <form action="{{ route('siswa-mi.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin hapus siswa ini?')">
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
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data siswa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $siswa->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
