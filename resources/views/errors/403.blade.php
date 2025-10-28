@extends('layouts.sbadmin')

@section('title', '403 Forbidden')

@section('content')

<style>
    /* Light mode */
    [data-bs-theme="light"] #content-wrapper,
    [data-bs-theme="light"] .container {
        background-color: #fff !important;
        color: #181515;
    }
    [data-bs-theme="light"] .card,
    [data-bs-theme="light"] .form-control {
        background-color: #f8f9fa !important;
        color: #000;
    }
    [data-bs-theme="light"] label {
        color: #000;
    }

    /* Dark mode */
    [data-bs-theme="dark"] #content-wrapper,
    [data-bs-theme="dark"] .container {
        background-color: #1B1B1DFF !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .form-control {
        background-color: #2c2c2e !important;
        color: #fff;
        border: 1px solid #444;
    }
    [data-bs-theme="dark"] label {
        color: #fff;
    }
</style>

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
