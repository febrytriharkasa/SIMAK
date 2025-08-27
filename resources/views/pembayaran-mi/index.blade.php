@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Pembayaran MI</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('pembayaran-mi.create') }}" class="btn btn-primary">+ Tambah Pembayaran</a>

        <!-- Form Search + Filter Bulan -->
        <form action="{{ route('pembayaran-mi.index') }}" method="GET" class="d-flex gap-2" style="max-width:500px;">
            <input type="text" name="nisn" class="form-control"
                   placeholder="Cari NISN" value="{{ request('nisn') }}">

            <input type="month" name="bulan" class="form-control"
                   value="{{ request('bulan') }}">

            <button type="submit" class="btn btn-secondary">Filter</button>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                        <th style="width:220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayaran as $p)
                        <tr>
                            <td>{{ $loop->iteration + ($pembayaran->currentPage()-1) * $pembayaran->perPage() }}</td>
                            <td>{{ $p->siswa->nisn ?? '-' }}</td>
                            <td>{{ $p->siswa->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::createFromDate($p->tahun, $p->bulan, 1)->translatedFormat('F Y') }}</td>
                            <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') : '-' }}</td>
                            <td>
                                @if($p->status == 'Belum Lunas')
                                    <span class="badge bg-danger">Belum</span>
                                @else
                                    <span class="badge bg-success">Lunas</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    @if($p->status == 'Belum Lunas')
                                        <!-- Tombol Bayar -->
                                        <a href="{{ route('pembayaran-mi.edit', $p->id) }}" class="btn btn-sm btn-success">
                                            Bayar
                                        </a>
                                    @endif

                                    <!-- Kwitansi -->
                                    @if($p->status == 'Lunas')
                                        <a href="{{ route('pembayaran-mi.kwitansi', $p->id) }}" class="btn btn-sm btn-info" target="_blank">
                                            Kwitansi
                                        </a>
                                    @endif

                                    <!-- Hapus -->
                                    <form action="{{ route('pembayaran-mi.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">Belum ada data pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $pembayaran->appends(['nisn' => request('nisn'), 'bulan' => request('bulan')])->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
