@extends('layouts.sbadmin')

@section('title', 'Password Requests')

@section('content')
<div class="container mt-5">
    <h3>Password Reset Requests</h3>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Table Wrapper -->
    <div class="card mt-3 shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Request Time</th>
                        <th style="width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $req->user->name }}</td>
                        <td>{{ $req->user->email }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($req->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($req->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @elseif($req->status == 'expired')
                                <span class="badge bg-secondary">Expired</span>
                            @endif
                        </td>
                        <td>{{ $req->created_at->format('d-m-Y H:i') }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <form action="{{ route('admin.password-requests.approve', $req->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm">Approve</button>
                                </form>
                                <form action="{{ route('admin.password-requests.reject', $req->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada request password.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
