@extends('layouts.sbadmin')

@section('title', 'Absensi Per Kelas')

@section('content')
<div class="container-fluid">
    <h4 class="fw-bold mb-4 ms-5">Input Absensi MI</h4>

<form action="{{ route('absensi-mi.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body row g-3">

                <div class="col-md-6">
                    <label class="fw-bold">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           class="form-control"
                           value="{{ date('Y-m-d') }}"
                           required>
                </div>

            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">Daftar Siswa</h6>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="siswa-container">
                        <tr>
                            <td colspan="4" class="text-muted p-3">
                                Pilih kelas terlebih dahulu
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
            <a href="{{ route('absensi-tk.index') }}" class="btn btn-secondary">
                Kembali
            </a>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Simpan Absensi
            </button>
        </div>

    </form>
</div>

{{-- Script --}}
<script>
document.getElementById('kelas_id').addEventListener('change', function () {
    let kelasId = this.value;
    let container = document.getElementById('siswa-container');

    if (!kelasId) {
        container.innerHTML = `
            <tr>
                <td colspan="4" class="text-muted">Pilih kelas terlebih dahulu</td>
            </tr>`;
        return;
    }

    fetch(`/absensi-mi/siswa/${kelasId}`)
        .then(res => res.json())
        .then(data => {
            container.innerHTML = '';

            if (data.length === 0) {
                container.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-muted">Tidak ada siswa</td>
                    </tr>`;
                return;
            }

            data.forEach((siswa, index) => {
                container.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td class="text-start">${siswa.nama}</td>
                        <td>
                            <select name="status[${siswa.id}]" class="form-select" required>
                                <option value="hadir">Hadir</option>
                                <option value="izin">Izin</option>
                                <option value="sakit">Sakit</option>
                                <option value="alfa">Alfa</option>
                            </select>
                        </td>
                        <td>
                            <input type="text"
                                   name="keterangan[${siswa.id}]"
                                   class="form-control"
                                   placeholder="Opsional">
                        </td>
                    </tr>
                `;
            });
        });
});
</script>
@endsection
