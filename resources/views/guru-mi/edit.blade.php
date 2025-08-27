@extends('layouts.sbadmin')

@section('content')
<div class="container">
    <h2>Edit Guru MI</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('guru-mi.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" 
                   value="{{ old('nama', $guru->nama) }}" required>
        </div>

        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" 
                   value="{{ old('nip', $guru->nip) }}" required>
        </div>

        <div class="mb-3">
            <label>Mata Pelajaran</label>
            <input type="text" name="mapel" class="form-control" 
                   value="{{ old('mapel', $guru->mapel) }}" required>
        </div>

        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="no_hp_guru" class="form-control" 
                   value="{{ old('no_hp_guru', $guru->no_hp_guru) }}" required>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat_guru" class="form-control" rows="3" required>{{ old('alamat_guru', $guru->alamat_guru) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('guru-mi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
