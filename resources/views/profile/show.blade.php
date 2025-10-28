@extends('layouts.sbadmin')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4"><i class="fas fa-user-circle me-2"></i>Profil Saya</h3>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Profil Card --}}
    <div class="card shadow-lg border-0">
        <div class="card-body row align-items-center">
            
            {{-- Foto Profil --}}
            <div class="col-md-3 text-center border-end">
                <img 
                    src="{{ Auth::user()->foto ? route('profile.avatar', Auth::user()->id) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=4e73df&color=fff' }}" 
                    alt="Foto Profil" 
                    class="img-thumbnail rounded-circle mb-3 shadow-sm"
                    style="width:150px; height:150px; object-fit:cover;">

                <div class="d-grid gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Profil
                    </a>
                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-1"></i> Ganti Password
                    </button>
                </div>
            </div>

            {{-- Data Profil --}}
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <tbody>
                            <tr><th width="35%">NIP</th><td>{{ Auth::user()->nip ?? '-' }}</td></tr>
                            <tr><th>Nama</th><td>{{ Auth::user()->name }}</td></tr>
                            <tr><th>Email</th><td>{{ Auth::user()->email }}</td></tr>
                            <tr><th>No. HP</th><td>{{ Auth::user()->no_hp ?? '-' }}</td></tr>
                            <tr><th>Tempat, Tanggal Lahir</th>
                                <td>{{ Auth::user()->tempat_lahir ?? '-' }}, {{ Auth::user()->tanggal_lahir ?? '-' }}</td>
                            </tr>
                            <tr><th>Jenis Kelamin</th><td>{{ Auth::user()->jenis_kelamin ?? '-' }}</td></tr>
                            <tr><th>Agama</th><td>{{ Auth::user()->agama ?? '-' }}</td></tr>
                            <tr><th>Alamat</th><td>{{ Auth::user()->alamat ?? '-' }}</td></tr>
                            <tr>
                                <th>Terakhir Ganti Password</th>
                                <td>{{ Auth::user()->last_password_changed_at ? Auth::user()->last_password_changed_at->format('d M Y H:i') : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Modal Ganti Password --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="{{ route('profile.update-password') }}" class="modal-content shadow-lg">
        @csrf
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="changePasswordModalLabel">
                <i class="fas fa-key me-2"></i> Ganti Password
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label fw-semibold">Password Lama</label>
                <input type="password" name="current_password" class="form-control" placeholder="Masukkan password lama" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password Baru</label>
                <input type="password" name="new_password" class="form-control" placeholder="Masukkan password baru" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Konfirmasi password baru" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Batal
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
  </div>
</div>
@endsection
