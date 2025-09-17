@extends('layouts.sbadmin')

@section('title', 'Pembayaran TK')

@section('content')
<div class="container-fluid">
    <div class="page-heading mb-40">
        <h3 class="ms-5">Administrasi TK</h3>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Card Filter --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                {{-- Tombol Tambah --}}
                <a href="{{ route('pembayaran-tk.create', [
                        'bulan' => request('bulan'),
                        'tahun' => request('tahun'),
                        'id_tk' => request('id_tk'),
                        'kelas_id' => request('kelas_id')
                    ]) }}" class="btn btn-primary">
                    + Tambah Pembayaran
                </a>

                {{-- Tombol Generate SPP --}}
                <a href="{{ route('pembayaran-mi.generateForm-tk') }}" class="btn btn-success">
                    <i class="fas fa-cogs"></i> Generate SPP
                </a>

            </div>

           

            <form action="{{ route('pembayaran-tk.index') }}" method="GET" class="row g-3 align-items-end">
                
                {{-- Filter No Induk --}}
                <div class="col-md-4">
                    <label for="id_tk" class="form-label">Cari No Induk</label>
                    <input type="text" id="id_tk" name="id_tk" 
                           class="form-control" 
                           placeholder="Masukkan No Induk"
                           value="{{ request('id_tk') }}">
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
            <a href="{{ route('pembayaran-tk.export-pdf', [
                'bulan' => request('bulan'),
                'tk_id' => request('tk_id'),
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
                        <th>No Induk</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jumlah</th>
                        <th>Bulan</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                        <th style="width:280px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!request('bulan'))
                        <tr>
                            <td colspan="9" class="text-center">Pilih bulan & tahun terlebih dahulu.</td>
                        </tr>
                    @else
                        @forelse ($pembayaran as $p)
                            <tr>
                                <td>{{ $loop->iteration + ($pembayaran->currentPage()-1) * $pembayaran->perPage() }}</td>
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
                                            <form action="{{ route('pembayaran-tk.approve', $p->id) }}" method="POST" style="display:inline;">
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
