@extends('layouts.sbadmin')

@section('title', 'Approval User - SIMAK')

@section('content')

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Daftar User Pending Approval</h4>
    </div>

    {{-- Alert session --}}
    @foreach (['success', 'error', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }} shadow-sm">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    {{-- Daftar user --}}
    @if($users->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">User Menunggu Persetujuan</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th style="width: 200px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-start">{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @switch($user->status)
                                            @case('pending')
                                                <span class="badge-status badge-pending">Pending</span>
                                                @break
                                            @case('approved')
                                                <span class="badge-status badge-approved">Approved</span>
                                                @break
                                            @case('rejected')
                                                <span class="badge-status badge-rejected">Rejected</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            @if($user->status === 'pending')
                                                {{-- Tombol Approve --}}
                                                <form action="{{ route('admin.approvals.approve', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>

                                                {{-- Tombol Reject --}}
                                                <form action="{{ route('admin.approvals.reject', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted fst-italic">Tidak ada aksi</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center shadow-sm">
            Tidak ada user yang menunggu approval.
        </div>
    @endif
</div>
@endsection