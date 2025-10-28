@extends('layouts.sbadmin')

@section('title', 'Generate SPP')

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

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Generate SPP</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pembayaran-tk.generate-tk') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Pilih Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        {{-- Jenis Tagihan --}}
                        <div class="mb-3">
                            <label for="jenis_tagihan" class="form-label fw-semibold">Jenis Tagihan</label>
                            <select name="jenis_tagihan" id="jenis_tagihan" class="form-select" required>
                                <option value="">-- Pilih Jenis Tagihan --</option>
                                <option value="SPP">SPP</option>
                                <option value="Rekreasi">Rekreasi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <input type="text" id="jenis_tagihan_lainnya" name="jenis_tagihan_lainnya" class="form-control mt-2" 
                                placeholder="Masukkan jenis tagihan lainnya" style="display: none;">
                        </div>

                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select" required>
                                @for($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_default" class="form-label">Jumlah Default</label>
                            <input type="number" name="jumlah_default" id="jumlah_default" class="form-control" placeholder="Contoh: 150000" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Generate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
