@extends('layouts.sbadmin')

@section('title', 'Laporan Pembayaran TK')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Laporan Administrasi TK</h4>
    </div>

    {{-- Filter Form --}}
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan-pembayaran-tk.index') }}" class="row g-3 align-items-end">

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Kelas</label>
                    <select name="kelas_id" class="form-select">
                        <option value="">Pilih Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ $kelas_id == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Bulan</label>
                    <select name="bulan" class="form-select">
                        <option value="">Semua</option>
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="lunas" {{ $status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="belum" {{ $status == 'belum' ? 'selected' : '' }}>Belum</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Jenis Tagihan</label>
                    <input type="text" name="jenis_tagihan" class="form-control"
                           value="{{ $jenis_tagihan ?? '' }}" placeholder="Contoh: SPP">
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-funnel"></i> Tampilkan
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Jika belum difilter --}}
    @if(!$isFiltered)
        <div class="alert alert-warning text-center shadow-sm">
            Silakan pilih filter terlebih dahulu untuk menampilkan data pembayaran.
        </div>
    @else

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

                                                {{-- Kolom No, No Induk, Nama --}}
                                                @if($firstRow)
                                                    <td rowspan="{{ $totalRows }}">{{ $no++ }}</td>
                                                    <td rowspan="{{ $totalRows }}">{{ $siswaData->siswa->id_tk ?? '-' }}</td>
                                                    <td rowspan="{{ $totalRows }}">{{ $siswaNama }}</td>
                                                    @php $firstRow = false; @endphp
                                                @endif

                                                {{-- Jenis Tagihan --}}
                                                @if($i == 0)
                                                    <td rowspan="{{ $rowspanJenis }}">{{ $jenis }}</td>
                                                @endif

                                                {{-- Jumlah --}}
                                                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>

                                                {{-- Status --}}
                                                <td class="text-center">
                                                    @if($p->status === 'lunas')
                                                        <span class="badge bg-success">Lunas</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum</span>
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

        {{-- Pagination --}}
        @if($pagination)
            <div class="d-flex justify-content-center mt-3">
                {{ $pagination->appends(request()->query())->links() }}
            </div>
        @endif

    @endif

</div>

@endsection
