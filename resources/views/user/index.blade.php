@extends('layouts.sbadmin')

@section('title', 'User - SIMAK')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 ms-4">
        <h4 class="fw-bold">Data User Yayasan</h4>
    </div>
    
    <!-- Alert Notifikasi -->
    @foreach (['success', 'error', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} shadow-sm">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">Daftar User</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 200px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($users as $user)
                        <tr class="text-center">
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td class="text-start">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            {{-- Badge Role --}}
                            <td>
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="badge-role 
                                            @if($role->name == 'admin') badge-admin
                                            @elseif($role->name == 'guru') badge-guru
                                            @elseif($role->name == 'staff') badge-staff
                                            @else badge-default @endif
                                        ">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge badge-default">Belum ada</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- Tombol Edit 
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a> -->

                                    <!-- Tombol Reset Password -->
                                    <button type="button" 
                                        onclick="openResetModal({{ $user->id }})"
                                        class="btn btn-danger btn-sm" title="Reset Password">
                                        <i class="fas fa-key"></i>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('users.destroy', $user->id) }}" 
                                        method="POST" onsubmit="return confirm('Yakin hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data user.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $users->withQueryString()->links() }}
    </div>

</div>

<!-- Modal Reset Password -->
<div class="modal fade" id="resetModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg" 
         style="border-radius: 20px; overflow:hidden;">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Reset Password</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
          <p>Reset password user ini menjadi <b>'password'</b>?</p>
      </div>

      <div class="modal-footer justify-content-center">
        <form id="resetForm" method="POST">
            @csrf
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Reset</button>
        </form>
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function openResetModal(userId) {
    document.getElementById('resetForm').action = `/users/${userId}/reset-password`;
    new bootstrap.Modal(document.getElementById('resetModal')).show();
}
</script>
@endpush
