@extends('layouts.sbadmin')

@section('title', 'User')

@section('content')
{{-- ===================== CSS Custom (Light & Dark Mode) ===================== --}}
<style>
    /* Light mode */
    [data-bs-theme="light"] #content-wrapper,
    [data-bs-theme="light"] .container-fluid {
        background-color: #fff !important;
        color: #181515;
    }
    [data-bs-theme="light"] .card {
        background-color: #f8f9fa !important;
        color: #000;
    }
    [data-bs-theme="light"] .table thead {
        background-color: #e9ecef;
        color: #000;
    }

    /* Dark mode */
    [data-bs-theme="dark"] #content-wrapper,
    [data-bs-theme="dark"] .container-fluid {
        background-color: #1B1B1DFF !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .card {
        background-color: #2c2c2e !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .table thead {
        background-color: #3a3a3c;
        color: #fff;
    }
</style>

<div class="container-fluid p-3 rounded-3">
    {{-- ===================== Heading & Action Button ===================== --}}
    <div class="page-heading mb-4 d-flex align-items-center justify-content-between">
        <h3 class="ms-2">👤 Data User Yayasan</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary me-2">
            <i class="bi bi-plus-circle me-1"></i> Tambah User
        </a>
    </div>

    {{-- ===================== Tabel User ===================== --}}
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->roles->isNotEmpty())
                                    @foreach($user->roles as $role)
                                        <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                    @endforeach
                                @else
                                    <span class="text-muted">Belum ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
                            <td colspan="5" class="text-center text-muted">📭 Belum ada data user.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ===================== Pagination ===================== --}}
            <div class="d-flex justify-content-center mt-3">
                {{ $users->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
