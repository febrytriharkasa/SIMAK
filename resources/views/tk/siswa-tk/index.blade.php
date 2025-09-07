@extends('layouts.sbadmin')

@section('title', 'Data Siswa TK')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Data Siswa TK</h3>
    </div>

    {{-- Baris atas: tombol tambah + form search --}}
    <div class="d-flex justify-content-between mb-3">
        <div class="d-flex gap-2">
            {{-- Tombol Tambah Siswa --}}
            <a href="{{ route('siswa-tk.create') }}" class="btn btn-primary ms-5">+ Tambah Siswa</a>

            {{-- Tombol Naik Kelas --}}
            <a href="{{ route('siswa.naikKelasTk') }}" 
                class="btn btn-success"
                onclick="return confirm('Yakin ingin proses kenaikan kelas untuk semua siswa?')">
                <i class="fas fa-level-up-alt"></i> Naik Kelas
            </a>
        </div>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('siswa-tk.index') }}" class="form-inline">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" 
                    placeholder="Cari No Induk Siswa...">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
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
                    <tr>
                        <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                        <td>{{ $row->id_tk }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->kelas->nama_kelas ?? '-' }}</td> {{-- ✅ Tambahan --}}
                        <td>{{ $row->tahun }}</td>
                        <td>{{ $row->nama_wali }}</td>
                        <td>{{ $row->no_hp_wali }}</td>
                        <td>{{ $row->alamat_siswa }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                {{-- Tombol Edit --}}
                                <a href="{{ route('siswa-tk.edit', $row->id) }}" 
                                    class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Tombol Show --}}
                                <a href="{{ route('siswa-tk.show', $row->id) }}" 
                                    class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('siswa-tk.destroy', $row->id) }}" 
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
