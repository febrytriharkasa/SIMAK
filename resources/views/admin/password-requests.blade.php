@extends('layouts.sbadmin')

@section('title', 'Password Requests')

@section('content')
<div class="container mt-5">
    <h3>Password Reset Requests</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Email</th>
                <th>Status</th>
                <th>Request Time</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($requests as $req)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $req->user->name }}</td>
                <td>{{ $req->user->email }}</td>
                <td>{{ ucfirst($req->status) }}</td>
                <td>{{ $req->created_at }}</td>
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
            @endforeach
        </tbody>
    </table>
</div>
@endsection
