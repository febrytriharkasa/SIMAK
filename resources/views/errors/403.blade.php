@extends('layouts.sbadmin')

@section('title', '403 Forbidden')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="display-1 text-danger">403</h1>
    <h2 class="mb-4">Akses Ditolak</h2>
    <p class="mb-4">Anda tidak memiliki izin untuk mengakses halaman ini.</p>

    <a href="{{ url()->previous() }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Kembali
    </a>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        <i class="fas fa-home me-1"></i> Ke Dashboard
    </a>
</div>
@endsection
