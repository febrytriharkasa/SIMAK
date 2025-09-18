@extends('layouts.sbadmin')

@section('title', 'Nilai Siswa')

@section('content')
<div class="container mt-4">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Nilai Siswa: {{ $siswa->nama }}</h4>
        <a href="{{ route('nilai-tk.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Card Info Siswa --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h5 class="card-title mb-1">{{ $siswa->nama }}</h5>
                <p class="card-text mb-0">
                    Kelas: <span class="badge bg-primary">{{ $siswa->kelas->nama_kelas ?? '-' }}</span>
                </p>
            </div>
            {{-- Dropdown filter kelas --}}
            <form action="{{ route('nilai-tk.show', $siswa->id) }}" method="GET" class="d-flex align-items-center">
                <label for="kelas_id" class="me-2 mb-0 fw-bold">Filter Kelas:</label>
                <select name="kelas_id" id="kelas_id" class="form-select me-2" style="width:180px;">
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $kelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="bi bi-filter"></i> Tampilkan
                </button>
            </form>
        </div>
    </div>

    {{-- Tabel Nilai --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar Nilai</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Tugas</th>
                            <th>UTS</th>
                            <th>EAS</th>
                            <th>Nilai Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($nilais as $index => $nilai)
                            <tr class="text-center align-middle">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $nilai->mapel->nama_mapel }}</td>
                                <td>{{ $nilai->guru->nama }}</td>
                                <td>{{ is_array($nilai->tugas) ? implode(', ', $nilai->tugas) : $nilai->tugas }}</td>
                                <td>{{ $nilai->uts }}</td>
                                <td>{{ $nilai->eas }}</td>
                                <td>
                                    <span class="badge {{ $nilai->nilai_akhir >= 70 ? 'bg-success' : 'bg-danger' }}">
                                        {{ $nilai->nilai_akhir }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('nilai-tk.edit', $nilai->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-3">
                                    <span class="text-muted">Belum ada nilai untuk kelas ini.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
