@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Siswa MI</h1>

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('siswa-mi.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nisn">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}">
                    @error('nisn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}" placeholder="contoh: 2025">
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nama_wali">Nama Wali</label>
                    <input type="text" name="nama_wali" id="nama_wali" class="form-control @error('nama_wali') is-invalid @enderror" value="{{ old('nama_wali') }}">
                    @error('nama_wali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_hp_wali">No HP Wali</label>
                    <input type="text" name="no_hp_wali" id="no_hp_wali" class="form-control @error('no_hp_wali') is-invalid @enderror" value="{{ old('no_hp_wali') }}">
                    @error('no_hp_wali')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alamat_siswa">Alamat</label>
                    <textarea name="alamat_siswa" id="alamat_siswa" rows="3" class="form-control @error('alamat_siswa') is-invalid @enderror">{{ old('alamat_siswa') }}</textarea>
                    @error('alamat_siswa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('siswa-mi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
