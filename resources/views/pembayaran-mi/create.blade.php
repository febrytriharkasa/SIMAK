@extends('layouts.sbadmin')

@section('content')
<div class="container">
    <h2>Tambah Pembayaran</h2>

    <form action="{{ route('pembayaran-mi.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="siswa_id" class="form-label">NISN Siswa</label>
            <select name="siswa_id" id="siswa_id" class="form-control" style="width: 100%;" required>
                <option value="">-- Pilih NISN Siswa --</option>
                @foreach($siswa as $s)
                    <option value="{{ $s->id }}" data-nama="{{ $s->nama }}">{{ $s->nisn }}</option>
                @endforeach
            </select>
            @error('siswa_id') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        {{-- Nama siswa otomatis tampil setelah memilih NISN --}}
        <div class="mb-3" id="namaSiswaWrapper" style="display:none;">
            <label class="form-label">Nama Siswa</label>
            <input type="text" id="nama_siswa" class="form-control" readonly>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" class="form-control" value="100000" readonly>
            @error('jumlah') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            @error('tanggal') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="belum" {{ old('status') == 'belum' ? 'selected' : '' }}>Belum</option>
                <option value="lunas" {{ old('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
            @error('status') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pembayaran-mi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#siswa_id').select2({
                theme: "classic",
                placeholder: "-- Pilih Siswa --",
                allowClear: true
            });

            // Saat pilihan berubah, tampilkan nama siswa
            $('#siswa_id').on('change', function() {
                let nama = $(this).find(':selected').data('nama');
                if (nama) {
                    $('#nama_siswa').val(nama);
                    $('#namaSiswaWrapper').show();
                } else {
                    $('#nama_siswa').val('');
                    $('#namaSiswaWrapper').hide();
                }
            });
        });
    </script>
@endpush
