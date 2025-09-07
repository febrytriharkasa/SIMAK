@extends('layouts.sbadmin')

@section('title', 'User')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Data User Yayasan</h3>
    </div>

    {{-- Baris atas: tombol tambah + form search --}}
    <!-- Form<div class="d-flex justify-content-between mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">+ Tambah Siswa</a>

         Pencarian 
        <form method="GET" action="{{ route('siswa-mi.index') }}" class="form-inline">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" 
                    placeholder="Cari NISN...">
            <button type="submit" class="btn btn-secondary">Cari</button>
        </form>
    </div> -->

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th style="width: 150px;">Aksi</th>
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
                                    <span class="badge badge-info">{{ $role->name }}</span>
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
@endsection
