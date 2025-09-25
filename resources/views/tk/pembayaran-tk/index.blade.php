@extends('layouts.sbadmin')

@section('title', 'Pembayaran TK')

@section('content')
    {{-- ===================== CSS Light & Dark ===================== --}}
    <style>
        /* Light mode */
        [data-bs-theme="light"] #content-wrapper,
        [data-bs-theme="light"] .container-fluid {
            background-color: #fff !important;
            color: #181515;
        }
        [data-bs-theme="light"] .table thead {
            background-color: #f8f9fa;
            color: #000;
        }

        /* Dark mode */
        [data-bs-theme="dark"] #content-wrapper,
        [data-bs-theme="dark"] .container-fluid {
            background-color: #1B1B1DFF !important;
            color: #fff;
        }
        [data-bs-theme="dark"] .table thead {
            background-color: #2c2c2e;
            color: #fff;
        }
    </style>

    <div class="container-fluid">
        {{-- ===================== Heading ===================== --}}
        <div class="page-heading mb-4 d-flex align-items-center justify-content-between">
            <h3 class="ms-2">💳 Administrasi TK</h3>
        </div>

        {{-- ===================== Alert ===================== --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ===================== Card Filter ===================== --}}
        <div class="card shadow-sm rounded-4 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    {{-- Tambah --}}
                    <a href="{{ route('pembayaran-tk.create', [
                            'bulan' => request('bulan'),
                            'tahun' => request('tahun'),
                            'id_tk' => request('id_tk'),
                            'kelas_id' => request('kelas_id')
                        ]) }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Pembayaran
                    </a>

                    {{-- Generate --}}
                    <a href="{{ route('pembayaran-mi.generateForm-tk') }}" class="btn btn-success">
                        <i class="fas fa-cogs"></i> Generate SPP
                    </a>
                </div>

                {{-- Filter --}}
                <form action="{{ route('pembayaran-tk.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="id_tk" class="form-label">Cari No Induk</label>
                        <input type="text" id="id_tk" name="id_tk"
                            class="form-control" placeholder="Masukkan No Induk"
                            value="{{ request('id_tk') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <input type="month" id="bulan" name="bulan"
                            class="form-control" value="{{ request('bulan') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select name="kelas_id" class="form-control">
                            <option value="">-- Semua Kelas --</option>
                            @foreach($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ===================== Cetak Laporan ===================== --}}
        @if(request('bulan'))
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('pembayaran-tk.export-pdf', [
                        'bulan' => request('bulan'),
                        'tk_id' => request('tk_id'),
                        'tahun' => request('tahun'),
                        'kelas_id' => request('kelas_id')
                    ]) }}"
                    class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> Cetak Laporan
                </a>
            </div>
        @else
            <div class="alert alert-warning mb-3">
                Silakan pilih <strong>bulan & tahun</strong> untuk menampilkan data pembayaran.
            </div>
        @endif

        {{-- ===================== Card Tabel ===================== --}}
        <div class="card shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="text-center">
                            <tr>
                                <th>No</th>
                                <th>No Induk</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jumlah</th>
                                <th>Bulan</th>
                                <th>Tanggal Bayar</th>
                                <th>Status</th>
                                <th style="width: 280px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!request('bulan'))
                                <tr>
                                    <td colspan="9" class="text-center">📅 Pilih bulan & tahun terlebih dahulu.</td>
                                </tr>
                            @else
                                @forelse ($pembayaran as $p)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration + ($pembayaran->currentPage()-1) * $pembayaran->perPage() }}</td>
                                        <td>{{ $p->siswa->id_tk ?? '-' }}</td>
                                        <td>{{ $p->siswa->nama ?? '-' }}</td>
                                        <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                        <td>{{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->translatedFormat('F Y') : '-' }}</td>
                                        <td>{{ $p->tanggal_bayar ? \Carbon\Carbon::parse($p->tanggal_bayar)->format('d-m-Y') : '-' }}</td>
                                        <td>
                                            @if($p->status == 'belum')
                                                <span class="badge bg-danger">Belum Lunas</span>
                                            @else
                                                <span class="badge bg-success">Lunas</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($p->status == 'belum')
                                                    <form action="{{ route('pembayaran-tk.approve', $p->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('pembayaran-tk.edit', [
                                                        'pembayaran_tk' => $p->id,
                                                        'bulan' => request('bulan'),
                                                        'tahun' => request('tahun'),
                                                        'id_tk' => request('id_tk'),
                                                        'kelas_id' => request('kelas_id')
                                                    ]) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                @if(strtolower($p->status) == 'lunas')
                                                    <a href="{{ route('pembayaran-tk.kwitansi-pdf', $p->id) }}" 
                                                        class="btn btn-sm btn-info" target="_blank">
                                                        <i class="fas fa-receipt"></i>
                                                    </a>
                                                @endif

                                                <form action="{{ route('pembayaran-tk.destroy', [
                                                        'pembayaran_tk' => $p->id,
                                                        'bulan' => request('bulan'),
                                                        'tahun' => request('tahun'),
                                                        'id_tk' => request('id_tk'),
                                                        'kelas_id' => request('kelas_id')
                                                    ]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="9" class="text-center">📭 Tidak ada data pada filter yang dipilih.</td></tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($pembayaran instanceof \Illuminate\Contracts\Pagination\Paginator)
                    <div class="d-flex justify-content-center mt-3">
                        {{ $pembayaran->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
