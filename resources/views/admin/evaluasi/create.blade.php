@extends('dashboard')

@section('title', 'Tambah Evaluasi Kinerja')

@section('content')
    {{-- ===================== CSS Custom (Light & Dark Mode) ===================== --}}
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

    <div class="container p-4 rounded-3">
        <h3 class="mb-3 ms-2">📝 Tambah Evaluasi Kinerja</h3>

        <form action="{{ route('evaluasi.store') }}" method="POST" class="card shadow-sm rounded-4 p-4">
            @csrf
            <div class="mb-3">
                <label>Pegawai/Guru</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Pilih Pegawai --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->nip }} - {{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Periode</label>
                <input type="text" name="periode" class="form-control" placeholder="2025-09">
            </div>

            <div class="row">
                <div class="col-md-2 mb-2"><input type="number" name="disiplin" class="form-control" placeholder="Disiplin"></div>
                <div class="col-md-2 mb-2"><input type="number" name="tanggung_jawab" class="form-control" placeholder="Tanggung Jawab"></div>
                <div class="col-md-2 mb-2"><input type="number" name="kerjasama" class="form-control" placeholder="Kerjasama"></div>
                <div class="col-md-2 mb-2"><input type="number" name="kompetensi" class="form-control" placeholder="Kompetensi"></div>
                <div class="col-md-2 mb-2"><input type="number" name="kehadiran" class="form-control" placeholder="Kehadiran"></div>
            </div>

            <div class="mb-3 mt-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control"></textarea>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success"><i class="bi bi-save me-1"></i> Simpan</button>
                <a href="{{ route('evaluasi.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Kembali</a>
            </div>
        </form>
    </div>
@endsection
