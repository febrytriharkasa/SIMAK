@extends('layouts.sbadmin')

@section('title', 'Pembayaran MI')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Data Pembayaran MI</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Card Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                {{-- Tombol Tambah --}}
                <a href="{{ route('pembayaran-mi.create', [
                        'bulan' => request('bulan'),
                        'tahun' => request('tahun'),
                        'nisn' => request('nisn'),
                        'kelas_id' => request('kelas_id')
                    ]) }}" class="btn btn-primary">
                    + Tambah Pembayaran
                </a>
            </div>

            <form action="{{ route('pembayaran-mi.index') }}" method="GET" class="row g-3 align-items-end">
                
                {{-- Filter NISN --}}
                <div class="col-md-4">
                    <label for="nisn" class="form-label">Cari NISN</label>
                    <input type="text" id="nisn" name="nisn" 
                           class="form-control" 
                           placeholder="Masukkan NISN"
                           value="{{ request('nisn') }}">
                </div>

                {{-- Filter Bulan --}}
                <div class="col-md-3">
                    <label for="bulan" class="form-label">Bulan</label>
                    <input type="month" id="bulan" name="bulan" 
                           class="form-control" 
                           value="{{ request('bulan') }}">
                </div>

                {{-- Filter Kelas --}}
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

                {{-- Tombol Filter --}}
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tombol Cetak Laporan (hanya muncul jika bulan dipilih) --}}
    @if(request('bulan'))
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('pembayaran-mi.export-pdf', [
                'bulan' => request('bulan'),
                'nisn' => request('nisn'),
                'tahun' => request('tahun'),
                'kelas_id' => request('kelas_id')
            ]) }}" 
            class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf"></i> Cetak Laporan Pembayaran
            </a>
        </div>
    @endif

    {{-- Info: belum pilih bulan --}}
    @if(!request('bulan'))
        <div class="alert alert-warning mb-3">
            Silakan pilih <strong>bulan & tahun</strong> untuk menampilkan data pembayaran.
        </div>
    @endif

    {{-- Card Tabel --}}
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                        <th style="width:280px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!request('bulan'))
                        <tr>
                            <td colspan="8" class="text-center">Pilih bulan & tahun terlebih dahulu.</td>
                        </tr>
                    @else
                        @forelse ($pembayaran as $p)
                            <tr>
                                <td>{{ $loop->iteration + ($pembayaran->currentPage()-1) * $pembayaran->perPage() }}</td>
                                <td>{{ $p->siswa->nisn ?? '-' }}</td>
                                <td>{{ $p->siswa->nama ?? '-' }}</td>
                               <td>{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') : '-' }}</td>
                                <td>
                                    @if($p->status == 'belum')
                                        <span class="badge bg-danger">Belum Lunas</span>
                                    @else
                                        <span class="badge bg-success">Lunas</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('pembayaran-mi.edit', [
                                            $p->id,
                                            'bulan' => request('bulan'),
                                            'tahun' => request('tahun'),
                                            'nisn' => request('nisn'),
                                            'kelas_id' => request('kelas_id')
                                            ]) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        @if(strtolower($p->status) == 'lunas')
                                           <a href="{{ route('pembayaran-mi.kwitansi-pdf', $p->id) }}" 
                                                class="btn btn-sm btn-info" target="_blank">
                                                    <i class="fas fa-receipt"></i>
                                            </a>
                                        @endif

                                       <form action="{{ route('pembayaran-mi.destroy', [
                                                $p->id,
                                                'bulan' => request('bulan'),
                                                'tahun' => request('tahun'),
                                                'nisn' => request('nisn'),
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
                            <tr><td colspan="8" class="text-center">Tidak ada data pada filter yang dipilih.</td></tr>
                        @endforelse
                    @endif
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($pembayaran instanceof \Illuminate\Contracts\Pagination\Paginator)
                <div class="d-flex justify-content-center">
                    {{ $pembayaran->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
