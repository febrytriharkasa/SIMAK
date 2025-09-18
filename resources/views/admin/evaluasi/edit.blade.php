@extends('dashboard')

@section('content')
<div class="container">
    <h3 class="mb-3 ms-5">Edit Evaluasi Kinerja</h3>

    <form action="{{ route('evaluasi.update', $evaluasi->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Pegawai/Guru</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $evaluasi->user_id ? 'selected' : '' }}>
                        {{ $user->nip }} - {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Periode</label>
            <input type="text" name="periode" class="form-control" value="{{ old('periode', $evaluasi->periode) }}">
        </div>

        <div class="row">
            <div class="col-md-2">
                <input type="number" name="disiplin" class="form-control" 
                       value="{{ old('disiplin', $evaluasi->disiplin) }}" placeholder="Disiplin">
            </div>
            <div class="col-md-2">
                <input type="number" name="tanggung_jawab" class="form-control" 
                       value="{{ old('tanggung_jawab', $evaluasi->tanggung_jawab) }}" placeholder="Tanggung Jawab">
            </div>
            <div class="col-md-2">
                <input type="number" name="kerjasama" class="form-control" 
                       value="{{ old('kerjasama', $evaluasi->kerjasama) }}" placeholder="Kerjasama">
            </div>
            <div class="col-md-2">
                <input type="number" name="kompetensi" class="form-control" 
                       value="{{ old('kompetensi', $evaluasi->kompetensi) }}" placeholder="Kompetensi">
            </div>
            <div class="col-md-2">
                <input type="number" name="kehadiran" class="form-control" 
                       value="{{ old('kehadiran', $evaluasi->kehadiran) }}" placeholder="Kehadiran">
            </div>
        </div>

        <div class="mb-3 mt-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $evaluasi->deskripsi) }}</textarea>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('evaluasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection