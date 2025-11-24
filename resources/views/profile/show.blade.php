@extends('layouts.sbadmin')

@section('title', 'Profil Saya')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')
<div class="container-fluid">
    <h3 class="ms-4 mb-4">Profil Saya</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-body row">
            <div class="col-md-3 text-center">
                <img 
                    src="{{ Auth::user()->foto ? route('profile.avatar', Auth::user()->id) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=435ebe&color=fff' }}" 
                    alt="Foto Profil" 
                    class="img-fluid rounded-circle mb-3 shadow-sm" 
                    style="width: 200px; height: 200px; object-fit: cover;">

                <div class="d-grid gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit Profil
                    </a>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="fas fa-key me-1"></i> Ganti Password
                    </button>
                </div>
            </div>

            <div class="col-md-9">
                <table class="table table-borderless align-middle">
                    <tr><th width="30%">NIP</th><td>{{ Auth::user()->nip ?? '-' }}</td></tr>
                    <tr><th>Nama</th><td>{{ Auth::user()->name }}</td></tr>
                    <tr><th>Email</th><td>{{ Auth::user()->email }}</td></tr>
                    <tr><th>No HP</th><td>{{ Auth::user()->no_hp ?? '-' }}</td></tr>
                    <tr><th>Tempat, Tanggal Lahir</th><td>{{ Auth::user()->tempat_lahir ?? '-' }}, {{ Auth::user()->tanggal_lahir ?? '-' }}</td></tr>
                    <tr><th>Jenis Kelamin</th><td>{{ Auth::user()->jenis_kelamin ?? '-' }}</td></tr>
                    <tr><th>Agama</th><td>{{ Auth::user()->agama ?? '-' }}</td></tr>
                    <tr><th>Alamat</th><td>{{ Auth::user()->alamat ?? '-' }}</td></tr>
                    <tr>
                        <th>Terakhir Ganti Password</th>
                        @php $lastChange = Auth::user()->last_password_changed_at; @endphp
                        <td>{{ $lastChange ? $lastChange->format('d M Y H:i') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ganti Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-theme">
      
      <div class="modal-header modal-header-theme">
        <h5 class="modal-title" id="changePasswordLabel">Ganti Password</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('profile.update-password') }}">
        @csrf
        @method('PATCH')
        <div class="modal-body">
          <div class="mb-3">
              <label>Password Lama</label>
              <input type="password" name="current_password" class="form-control form-control-theme" required>
              @error('current_password')
                  <span class="text-danger-theme">{{ $message }}</span>
              @enderror
          </div>

          <div class="mb-3">
              <label>Password Baru</label>
              <input type="password" name="new_password" class="form-control form-control-theme" required minlength="6">
              @error('new_password')
                  <span class="text-danger-theme">{{ $message }}</span>
              @enderror
          </div>

          <div class="mb-3">
              <label>Konfirmasi Password Baru</label>
              <input type="password" name="new_password_confirmation" class="form-control form-control-theme" required minlength="6">
          </div>
        </div>

        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-light btn-theme" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary btn-theme">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Toast Notifikasi -->
<div id="toastContainer" class="custom-toast-container">
    @if(session('success'))
        <div class="custom-toast success-toast">
            <span>{{ session('success') }}</span>
            <span class="closeToast">&times;</span>
        </div>
    @elseif(session('error'))
        <div class="custom-toast error-toast">
            <span>{{ session('error') }}</span>
            <span class="closeToast">&times;</span>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toast close
    document.querySelectorAll('.closeToast').forEach(btn => {
        btn.onclick = function() {
            btn.parentElement.style.display = 'none';
        }
    });

    // Auto-hide toast
    document.querySelectorAll('.custom-toast').forEach(toast => {
        setTimeout(() => toast.style.display = 'none', 4000);
    });
});
</script>
@endpush