@extends('layouts.sbadmin')

@section('title', 'Data Siswa MI')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Data Siswa MI</h3>
    </div>

    {{-- Baris atas: tombol tambah + form search --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex gap-2">
            {{-- Tombol Tambah Siswa --}}
            <a href="{{ route('siswa-mi.create') }}" class="btn btn-primary ms-5">+ Tambah Siswa</a>
        </div>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('siswa-mi.index') }}" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" 
                class="form-control me-2" placeholder="Cari NISN...">
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
                    <tr>
                        <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                        <td>{{ $row->nisn }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->kelas->nama_kelas ?? '-' }}</td> {{-- ✅ Tambahan --}}
                        <td>{{ $row->tahun }}</td>
                        <td>{{ $row->nama_wali }}</td>
                        <td>{{ $row->no_hp_wali }}</td>
                        <td>{{ $row->alamat_siswa }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('siswa-mi.edit', $row->id) }}" 
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Tombol Show --}}
                                <a href="{{ route('siswa-mi.show', $row->id) }}" 
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('siswa-mi.destroy', $row->id) }}" 
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
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data siswa.</td> {{-- ✅ colspan jadi 9 --}}
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
