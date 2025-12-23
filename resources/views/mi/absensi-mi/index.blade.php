@extends('layouts.sbadmin')

@section('title', 'Data Absensi MI')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Data Absensi MI</h4>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- FILTER --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">

            {{-- BARIS TOMBOL ATAS --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="{{ route('absensi-mi.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Input Absensi
                </a>

                {{-- placeholder kanan (opsional, samakan seperti gambar) --}}
                {{--
                <a href="#" class="btn btn-success">
                    <i class="bi bi-gear"></i> Generate Absensi
                </a>
                --}}
            </div>

            {{-- BARIS FILTER --}}
            <form method="GET" class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="fw-bold">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="fw-bold">Tanggal (Opsional)</label>
                    <input type="date"
                        name="tanggal"
                        class="form-control"
                        value="{{ request('tanggal') }}">
                </div>


                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- TABEL ABSENSI --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Absensi</h6>
        </div>

        <div class="card-body p-0">
            @if($absensi->count())
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th style="width:120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($absensi as $a)
                        <tr class="align-middle">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start">{{ $a->siswa->nama }}</td>
                            <td>{{ $a->siswa->kelas->nama_kelas }}</td>
                            <td>{{ $a->tahunAjaran->nama_tahun ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge 
                                        @if($a->status=='hadir') bg-success
                                        @elseif($a->status=='izin') bg-info
                                        @elseif($a->status=='sakit') bg-warning
                                        @else bg-danger
                                        @endif">
                                    {{ strtoupper($a->status) }}
                                </span>
                            </td>
                            <td class="text-start">{{ $a->keterangan ?? '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('absensi-mi.edit', $a->id) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('absensi-mi.destroy', $a->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-4 text-center text-muted">
                <em>Silakan pilih kelas absensi.</em>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection