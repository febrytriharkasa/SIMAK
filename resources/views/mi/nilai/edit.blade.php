@extends('layouts.sbadmin')

@section('title', 'Edit Nilai Siswa MI')

@section('content')

<style>
    /* Light mode */
    [data-bs-theme="light"] #content-wrapper,
    [data-bs-theme="light"] .container {
        background-color: #fff !important;
        color: #181515;
    }
    [data-bs-theme="light"] .card,
    [data-bs-theme="light"] .form-control {
        background-color: #f8f9fa !important;
        color: #000;
    }
    [data-bs-theme="light"] label {
        color: #000;
    }

    /* Dark mode */
    [data-bs-theme="dark"] #content-wrapper,
    [data-bs-theme="dark"] .container {
        background-color: #1B1B1DFF !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .form-control {
        background-color: #2c2c2e !important;
        color: #fff;
        border: 1px solid #444;
    }
    [data-bs-theme="dark"] label {
        color: #fff;
    }
</style>

<div class="container-fluid">
    <div class="page-heading mb-4 ms-5">
        <h3>Edit Nilai Siswa MI</h3>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="siswa_id" class="form-label">Siswa</label>
                    <select name="siswa_id" id="siswa_id" class="form-control">
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}" {{ $nilai->siswa_id == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="mapel_id" class="form-label">Mata Pelajaran</label>
                    <select name="mapel_id" id="mapel_id" class="form-control">
                        @foreach($mapel as $m)
                            <option value="{{ $m->id }}" {{ $nilai->mapel_id == $m->id ? 'selected' : '' }}>
                                {{ $m->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="guru_id" class="form-label">Guru</label>
                    <select name="guru_id" id="guru_id" class="form-control">
                        @foreach($guru as $g)
                            <option value="{{ $g->id }}" {{ $nilai->guru_id == $g->id ? 'selected' : '' }}>
                                {{ $g->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-control">
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $nilai->kelas_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tugas" class="form-label">Tugas (pisahkan dengan koma)</label>
                    <input type="text" name="tugas" id="tugas" class="form-control" 
                        value="{{ is_array($nilai->tugas) ? implode(',', $nilai->tugas) : $nilai->tugas }}">
                </div>

                <div class="mb-3">
                    <label for="uts" class="form-label">UTS</label>
                    <input type="number" name="uts" id="uts" class="form-control" value="{{ $nilai->uts }}">
                </div>

                <div class="mb-3">
                    <label for="eas" class="form-label">EAS</label>
                    <input type="number" name="eas" id="eas" class="form-control" value="{{ $nilai->eas }}">
                </div>

                <div class="mb-3">
                    <label for="nilai_akhir" class="form-label">Nilai Akhir</label>
                    <input type="number" name="nilai_akhir" id="nilai_akhir" class="form-control" value="{{ $nilai->nilai_akhir }}" readonly>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle"></i> Update
                    </button>
                    <a href="{{ route('nilai.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
