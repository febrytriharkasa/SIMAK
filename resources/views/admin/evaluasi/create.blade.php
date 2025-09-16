@extends('dashboard')

@section('content')
<div class="container">
    <h3 class="mb-3">Tambah Evaluasi Kinerja</h3>

    <form action="{{ route('evaluasi.store') }}" method="POST">
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
            <div class="col-md-2"><input type="number" name="disiplin" class="form-control" placeholder="Disiplin"></div>
            <div class="col-md-2"><input type="number" name="tanggung_jawab" class="form-control" placeholder="Tanggung Jawab"></div>
            <div class="col-md-2"><input type="number" name="kerjasama" class="form-control" placeholder="Kerjasama"></div>
            <div class="col-md-2"><input type="number" name="kompetensi" class="form-control" placeholder="Kompetensi"></div>
            <div class="col-md-2"><input type="number" name="kehadiran" class="form-control" placeholder="Kehadiran"></div>
        </div>

        <div class="mb-3 mt-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('evaluasi.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
