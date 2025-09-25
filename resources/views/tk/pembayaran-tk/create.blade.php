@extends('layouts.sbadmin')

@section('title', 'Generate SPP')

@section('content')
{{-- ===================== CSS Custom (Light & Dark Mode) ===================== --}}
<style>
    /* ================== Light Mode ================== */
    [data-bs-theme="light"] #content-wrapper,
    [data-bs-theme="light"] .container,
    [data-bs-theme="light"] .card {
        background-color: #fff !important;
        color: #181515;
    }
    [data-bs-theme="light"] .card-header {
        background-color: #f8f9fa !important;
        color: #000;
    }
    [data-bs-theme="light"] .form-select,
    [data-bs-theme="light"] .form-control {
        background-color: #fff !important;
        color: #181515 !important;
        border: 1px solid #ccc !important;
    }
    [data-bs-theme="light"] .form-select option {
        background-color: #fff !important;
        color: #181515 !important;
    }

    /* ================== Dark Mode ================== */
    [data-bs-theme="dark"] #content-wrapper,
    [data-bs-theme="dark"] .container,
    [data-bs-theme="dark"] .card {
        background-color: #1B1B1DFF !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .card-header {
        background-color: #2c2c2e !important;
        color: #fff;
    }
    [data-bs-theme="dark"] .form-select,
    [data-bs-theme="dark"] .form-control {
        background-color: #2c2c2e !important;
        color: #fff !important;
        border: 1px solid #444 !important;
    }
    [data-bs-theme="dark"] .form-select option {
        background-color: #2c2c2e !important;
        color: #fff !important;
    }
</style>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Generate SPP</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pembayaran-mi.generate-mi') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label fw-semibold">Pilih Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bulan" class="form-label fw-semibold">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select" required>
                                @for($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label fw-semibold">Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_default" class="form-label fw-semibold">Jumlah Default</label>
                            <input type="number" name="jumlah_default" id="jumlah_default" class="form-control" placeholder="Contoh: 150000" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-check-circle"></i> Generate
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
