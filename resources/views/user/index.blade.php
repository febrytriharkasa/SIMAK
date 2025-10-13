@extends('layouts.sbadmin')

@section('title', 'User')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Data User Yayasan</h3>
    </div>

    <!-- Alert Notifikasi -->
    @foreach (['success', 'error', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->roles->isNotEmpty())
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info">{{ $role->name }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">Belum ada</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">

                                <!-- Tombol Edit -->
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Tombol Reset Password (Buka Modal) -->
                                <button type="button" class="btn btn-sm btn-danger" onclick="openResetModal({{ $user->id }})">
                                    <i class="fas fa-key"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                    onsubmit="return confirm('Yakin hapus data ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetModal" tabindex="-1" aria-labelledby="resetModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; box-shadow:0 8px 30px rgba(0,0,0,0.2);">
      
      <div class="modal-header" style="background: linear-gradient(45deg, #ff4b2b, #ff416c); color: white; border-bottom: none;">
        <h5 class="modal-title" id="resetModalLabel">Reset Password?</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center" style="padding: 25px;">
        <p style="font-size: 16px; margin: 0;">
            Apakah kamu yakin ingin mereset password user ini ke <b>'password'</b>?
        </p>
      </div>

      <div class="modal-footer justify-content-center" style="border-top: none; padding-bottom: 25px;">
        <form id="resetForm" method="POST">
            @csrf
            <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 12px; padding: 6px 18px;">Batal</button>
            <button type="submit" class="btn btn-danger" style="border-radius: 12px; padding: 6px 18px;">Reset</button>
        </form>
      </div>

    </div>
  </div>
</div>


@endsection

@push('scripts')
<script>
function openResetModal(userId) {
    const form = document.getElementById('resetForm');
    form.action = `/users/${userId}/reset-password`; 
    var myModal = new bootstrap.Modal(document.getElementById('resetModal'));
    myModal.show();
}
</script>
@endpush
