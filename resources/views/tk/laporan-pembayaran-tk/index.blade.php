@extends('layouts.sbadmin')

@section('title', 'Laporan Pembayaran TK')

@section('content')

<style>
    [data-bs-theme="light"] #content-wrapper,
    [data-bs-theme="light"] .container {
        background-color: #fff !important;
        color: #181515;
    }
    [data-bs-theme="dark"] #content-wrapper,
    [data-bs-theme="dark"] .container {
        background-color: #1B1B1DFF !important;
        color: #fff;
    }
    .badge-lunas {
        background-color: #28a745;
        color: #fff;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
    }
    .badge-belum {
        background-color: #dc3545;
        color: #fff;
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 500;
    }
</style>

<div class="container-fluid">
    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold text-primary mb-0">📘 Laporan Pembayaran TK</h4>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan-pembayaran-tk.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="kelas_id" class="form-label fw-semibold">Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-select">
                        <option value="">Semua</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelas_id == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="bulan" class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        <option value="">Semua</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="lunas" {{ $status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="belum" {{ $status == 'belum' ? 'selected' : '' }}>Belum</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="jenis_tagihan" class="form-label fw-semibold">Jenis Tagihan</label>
                    <input type="text" name="jenis_tagihan" id="jenis_tagihan"
                           value="{{ $jenis_tagihan ?? '' }}" class="form-control" placeholder="Contoh: SPP">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-funnel"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Pembayaran --}}
    @forelse($data as $kelasNama => $siswaList)
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-semibold">
                {{ strtoupper($kelasNama) }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>No</th>
                                <th>No Induk</th>
                                <th>Nama</th>
                                <th>Jenis Tagihan</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($siswaList as $siswaNama => $pembayaranList)
                                @php
                                    $grouped = $pembayaranList->groupBy('jenis_tagihan');
                                    $totalRows = $grouped->sum(fn($g) => count($g));
                                    $siswaData = $pembayaranList->first();
                                    $firstRow = true;
                                @endphp

                                @foreach($grouped as $jenis => $group)
                                    @php $rowspanJenis = count($group); @endphp
                                    @foreach($group as $i => $p)
                                        <tr>
                                            @if($firstRow)
                                                <td rowspan="{{ $totalRows }}">{{ $no++ }}</td>
                                                <td rowspan="{{ $totalRows }}">{{ $siswaData->siswa->id_tk ?? '-' }}</td>
                                                <td rowspan="{{ $totalRows }}">{{ $siswaNama }}</td>
                                                @php $firstRow = false; @endphp
                                            @endif

                                            @if($i == 0)
                                                <td rowspan="{{ $rowspanJenis }}">{{ $jenis }}</td>
                                            @endif

                                            <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                @if($p->status === 'lunas')
                                                    <span class="badge-lunas">Lunas</span>
                                                @else
                                                    <span class="badge-belum">Belum</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center shadow-sm">
            Tidak ada data pembayaran ditemukan.
        </div>
    @endforelse
</div>

@endsection
