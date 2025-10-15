@extends('layouts.sbadmin')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Profil Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body row">
            <div class="col-md-3 text-center">
                <img 
                    src="{{ Auth::user()->foto ? route('profile.avatar', Auth::user()->id) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=435ebe&color=fff' }}" 
                    alt="Foto Profil" 
                    class="img-fluid rounded mb-3" 
                    style="max-height:200px; object-fit:cover;">

                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Edit Profil</a>
                <button class="btn btn-warning btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Ganti Password</button>
            </div>

            <div class="col-md-9">
                <table class="table table-borderless">
                    <tr><th>NIP</th><td>{{ Auth::user()->nip ?? '-' }}</td></tr>
                    <tr><th>Nama</th><td>{{ Auth::user()->name }}</td></tr>
                    <tr><th>Email</th><td>{{ Auth::user()->email }}</td></tr>
                    <tr><th>No HP</th><td>{{ Auth::user()->no_hp ?? '-' }}</td></tr>
                    <tr><th>Tempat, Tanggal Lahir</th><td>{{ Auth::user()->tempat_lahir ?? '-' }}, {{ Auth::user()->tanggal_lahir ?? '-' }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ Auth::user()->jenis_kelamin ?? '-' }}</td></tr>
                    <tr><th>Agama</th><td>{{ Auth::user()->agama ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ Auth::user()->alamat ?? '-' }}</td></tr>
                    <tr><th>Terakhir Ganti Password</th><td>{{ Auth::user()->last_password_changed_at ? Auth::user()->last_password_changed_at->format('d M Y H:i') : '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('profile.update-password') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Password Lama</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password Baru</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection
