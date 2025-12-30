@extends('layouts.sbadmin')

@section('title', 'Pembayaran MI')

@section('content')


<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 ms-5">
        <h4 class="fw-bold">Administrasi MI</h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Card Filter & Aksi --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            {{-- Baris Tombol Aksi (Bagian Atas) --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('pembayaran-mi.generateForm-mi') }}" class="btn btn-success shadow-sm">
                    <i class="fas fa-cogs me-1"></i> Generate SPP
                </a>
            </div>

            <hr class="text-muted opacity-25">

            {{-- Baris Filter (Mengikuti Desain Gambar 2) --}}
            <form action="{{ route('pembayaran-mi.index') }}" method="GET">
                <div class="row g-3 align-items-end">

                    {{-- Filter NISN --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">NISN</label>
                        <input type="text" name="nisn" class="form-control border-light-subtle" 
                               placeholder="Masukkan NISN" 
                               value="{{ request('nisn') }}">
                    </div>

                    {{-- Filter Kelas --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Kelas</label>
                        <select name="kelas_id" class="form-select border-light-subtle">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                {{ $kelas->nama_kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Bulan --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Bulan</label>
                        <input type="month" name="bulan" class="form-control border-light-subtle" value="{{ request('bulan') }}">
                    </div>

                    {{-- Filter Status --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Status</label>
                        <select name="status" class="form-select border-light-subtle">
                            <option value="">Semua</option>
                            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Lunas</option>
                        </select>
                    </div>

                    {{-- Filter Jenis Tagihan --}}
                    <div class="col-md-2">
                        <label class="form-label small fw-bold text-secondary">Jenis Tagihan</label>
                        <select name="jenis_tagihan" class="form-select border-light-subtle">
                            <option value="">Contoh: SPP</option>
                            @foreach($jenisTagihanList as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis_tagihan') == $jenis ? 'selected' : '' }}>
                                {{ $jenis }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Tombol Tampilkan --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 shadow-sm">
                            <i class="fas fa-filter me-1"></i> Tampilkan
                        </button>
                    </div>
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
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Daftar Pembayaran MI</h6>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NISN</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tagihan</th>
                            <th>Jumlah</th>
                            <th>Bulan</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                            <th style="width: 220px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if(!request('bulan'))
                        <tr>
                            <td colspan="10" class="text-center text-muted p-3">
                                Pilih bulan & tahun terlebih dahulu.
                            </td>
                        </tr>
                        @else
                        @forelse($pembayaran as $p)
                        <tr>
                            <td>{{ $loop->iteration + ($pembayaran->currentPage()-1) * $pembayaran->perPage() }}</td>
                            <td>{{ $p->siswa->nisn ?? '-' }}</td>
                            <td class="text-start">{{ $p->siswa->nama ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $p->siswa->kelas->nama_kelas ?? '-' }}
                                </span>
                            </td>
                            <td>{{ $p->jenis_tagihan ?? '-' }}</td>
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
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Bayar (ganti Approve) --}}
                                    @if($p->status == 'belum')
                                    <form action="{{ route('pembayaran-mi.approve', $p->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-cash-stack"></i>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('pembayaran-mi.edit', [
                                                $p->id,
                                                'bulan' => request('bulan'),
                                                'tahun' => request('tahun'),
                                                'nisn' => request('nisn'),
                                                'kelas_id' => request('kelas_id')
                                            ]) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Tombol Kwitansi (hanya jika lunas) --}}
                                    @if(strtolower($p->status) == 'lunas')
                                    <a href="{{ route('pembayaran-mi.kwitansi-pdf', $p->id) }}"
                                        class="btn btn-sm btn-info text-white" target="_blank" title="Kwitansi">
                                        <i class="fas fa-receipt"></i>
                                    </a>
                                    @endif

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('pembayaran-mi.destroy', [
                                                $p->id,
                                                'bulan' => request('bulan'),
                                                'tahun' => request('tahun'),
                                                'nisn' => request('nisn'),
                                                'kelas_id' => request('kelas_id')
                                            ]) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted p-3">
                                Tidak ada data pada filter yang dipilih.
                            </td>
                        </tr>
                        @endforelse
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="p-3">
                {{ $pembayaran->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection