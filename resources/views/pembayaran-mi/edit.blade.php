@extends('layouts.sbadmin')

@section('content')
<div class="container">
    <h2>Edit / Konfirmasi Pembayaran</h2>

    <form action="{{ route('pembayaran-mi.update', $pembayaran->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Siswa --}}
        <div class="mb-3">
            <label for="siswa_id" class="form-label">Nama Siswa</label>
            <select name="siswa_id" id="siswa_id" class="form-select" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($siswa as $s)
                    <option value="{{ $s->id }}" {{ $s->id == $pembayaran->siswa_id ? 'selected' : '' }}>
                        {{ $s->nama }}
                    </option>
                @endforeach
            </select>
            @error('siswa_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Jumlah --}}
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" 
                   value="{{ old('jumlah', $pembayaran->jumlah ?? 100000) }}" readonly>
            @error('jumlah') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- {{-- Tanggal --}}
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" 
                   value="{{ old('tanggal', $pembayaran->tanggal) }}" required>
            @error('tanggal') <div class="text-danger">{{ $message }}</div> @enderror
        </div> -->

        {{-- Bulan (readonly) --}}
        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="number" name="bulan" id="bulan" class="form-control" 
                   value="{{ old('bulan', $pembayaran->bulan) }}" readonly>
        </div>

        {{-- Tahun (readonly) --}}
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" id="tahun" class="form-control" 
                   value="{{ old('tahun', $pembayaran->tahun) }}" readonly>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="belum" {{ old('status', $pembayaran->status) == 'belum' ? 'selected' : '' }}>Belum Bayar</option>
                <option value="lunas" {{ old('status', $pembayaran->status) == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update / Konfirmasi</button>
        <a href="{{ route('pembayaran-mi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
