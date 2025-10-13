@extends('layouts.sbadmin')

@section('title', 'Approval User')

@section('content')
<div class="page-heading mb-4">
    <h3 class="ms-4">Daftar User Pending Approval</h3>
    <p class="ms-4">Kelola persetujuan akun pengguna baru.</p>
</div>

<div class="container-fluid">
    <!-- Alert session -->
    @foreach (['success', 'error', 'info'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'error' ? 'danger' : $msg }}">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    @if($users->count() > 0)
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List User Menunggu Approval</h5>
            </div>
            <div class="card-body p-0">
                <table id="dataApproval" class="table table-hover table-bordered mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td class="align-middle">{{ $user->name }}</td>
                                <td class="align-middle">{{ $user->email }}</td>
                                <td class="align-middle text-center">
                                    @switch($user->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">⏳ Pending</span>
                                            @break
                                        @case('approved')
                                            <span class="badge bg-success">✅ Approved</span>
                                            @break
                                        @case('rejected')
                                            <span class="badge bg-danger">❌ Rejected</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="text-center">
                                    @if($user->status === 'pending')
                                        <form action="{{ route('admin.approvals.approve', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm" title="Approve">✅</button>
                                        </form>
                                        <form action="{{ route('admin.approvals.reject', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" title="Reject">❌</button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info text-center">
            Tidak ada user yang menunggu approval.
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataApproval').DataTable({
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "paginate": {
                "next": "Berikutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});
</script>

<!-- Hover Styling -->
<style>
    table tbody tr:hover {
        background-color: #f9fafb !important;
        transition: 0.2s;
    }
</style>
@endpush
