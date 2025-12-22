@extends('layouts.sbadmin')

@section('title', 'Edit Absensi TK')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Edit Absensi TK</h4>
    </div>

    <form action="{{ route('absensi-tk.update', $absensi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body row g-3">

                <div class="col-md-6">
                    <label class="fw-bold">Nama Siswa</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $absensi->siswa->nama }}"
                           readonly>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Kelas</label>
                    <input type="text"
                           class="form-control"
                           value="{{ $absensi->siswa->kelas->nama_kelas }}"
                           readonly>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Tanggal</label>
                    <input type="date"
                           class="form-control"
                           value="{{ $absensi->tanggal }}"
                           readonly>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="hadir" {{ $absensi->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="izin"  {{ $absensi->status == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ $absensi->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alfa"  {{ $absensi->status == 'alfa' ? 'selected' : '' }}>Alfa</option>
                    </select>
                </div>

                <div class="col-md-12">
                    <label class="fw-bold">Keterangan</label>
                    <input type="text"
                           name="keterangan"
                           class="form-control"
                           value="{{ $absensi->keterangan }}">
                </div>

            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('absensi-tk.index') }}" class="btn btn-secondary">
                Kembali
            </a>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Update Absensi
            </button>
        </div>

    </form>

</div>
@endsection
