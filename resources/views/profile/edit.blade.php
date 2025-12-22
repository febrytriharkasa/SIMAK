@extends('layouts.sbadmin')

@php 
    use Illuminate\Support\Str; 
@endphp

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Profil Saya</h4>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row g-4">
            @php
                $user = Auth::user();

                $fotoUrl = $user->foto
                    ? route('profile.avatar', $user->id)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=435ebe&color=fff';
            @endphp

            <div class="col-md-3 text-center">
                <img
                    id="previewFoto"
                    src="{{ $fotoUrl }}"
                    alt="Foto Profil"
                    style="
                        width:180px;
                        height:180px;
                        border-radius:50%;
                        object-fit:cover;
                        border:2px solid #ccc;
                        background:#f1f3f5;
                    "
                >

                <input
                    type="file"
                    name="foto"
                    class="form-control form-control-sm mt-2"
                    accept="image/*"
                    onchange="previewImage(this)"
                >
            </div>

            <!-- Data Profil -->
            <div class="col-md-9">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">NIP</label>
                        <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Agama</label>
                        <input type="text" name="agama" class="form-control" value="{{ old('agama', $user->agama) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat', $user->alamat) }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Mata Pelajaran</label>
                        <input type="text" name="mata_pelajaran" class="form-control" value="{{ old('mata_pelajaran', $user->mata_pelajaran) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kelas Diampu</label>
                        <input type="text" name="kelas_diampu" class="form-control" value="{{ old('kelas_diampu', $user->kelas_diampu) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $user->jabatan) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" class="form-control" value="{{ old('tanggal_masuk', $user->tanggal_masuk) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Pendidikan</label>
                        <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', $user->pendidikan) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status Kepegawaian</label>
                        <input type="text" name="status_kepegawaian" class="form-control" value="{{ old('status_kepegawaian', $user->status_kepegawaian) }}">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

<script>
function previewImage(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];

    if (!file.type.startsWith('image/')) {
        alert('File harus berupa gambar');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('previewFoto').src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection