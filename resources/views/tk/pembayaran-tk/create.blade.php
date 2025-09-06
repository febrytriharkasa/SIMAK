@extends('layouts.sbadmin')

@section('title', 'Pembayaran TK')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Pembayaran TK</h5>
                </div>
                <div class="card-body">

                    {{-- Alert --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('pembayaran-tk.store') }}" method="POST">
                        @csrf
                        
                        <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                        <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        <input type="hidden" name="id_tk" value="{{ request('id_tk') }}">
                        <input type="hidden" name="tahun_angkatan" value="{{ request('tahun_angkatan') }}">
                        
                        {{-- Pilih Siswa --}}
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label fw-semibold">Pilih Siswa</label>
                            <select name="siswa_id" id="siswa_id" class="form-control" required>
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($siswa as $s)
                                    <option value="{{ $s->id }}" 
                                            data-nama="{{ $s->nama }}" 
                                            data-id_tk="{{ $s->id_tk }}">
                                        {{ $s->id_tk }} - {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('siswa_id') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        {{-- Jumlah --}}
                        <div class="mb-3">
                            <label for="jumlah" class="form-label fw-semibold">Jumlah (Rp)</label>
                            <input type="number" name="jumlah" id="jumlah" class="form-control" 
                                   value="{{ old('jumlah', 100000) }}" readonly>
                            @error('jumlah') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tanggal --}}
                        <div class="mb-3">
                            <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control"
                                value="{{ old('tanggal', \Carbon\Carbon::today()->format('Y-m-d')) }}" required>
                            @error('tanggal') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="belum" {{ old('status') == 'belum' ? 'selected' : '' }}>Belum</option>
                                <option value="lunas" {{ old('status', 'lunas') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            </select>
                            @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                            <a href="{{ route('pembayaran-tk.index', [
                                        'bulan' => request('bulan'),
                                        'tahun' => request('tahun'),
                                        'id_tk' => request('id_tk'),
                                        'tahun_angkatan' => request('tahun_angkatan')
                                    ]) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
        function formatSiswa(option) {
            if (!option.id) return option.text;
            let nama = $(option.element).data('nama');
            let id_tk  = $(option.element).data('id_tk');
            return $(`
                <div>
                    <div><strong>${id_tk} - ${nama}</strong></div>
                    <div class="text-muted small">${nama}</div>
                </div>
            `);
        }

        function formatSiswaSelection(option) {
            if (!option.id) return option.text;
            let nama = $(option.element).data('nama');
            let id_tk  = $(option.element).data('id_tk');
            return `${id_tk} - ${nama}`;
        }

        $('#siswa_id').select2({
            theme: "bootstrap4",
            placeholder: "-- Pilih Siswa --",
            allowClear: true,
            templateResult: formatSiswa,
            templateSelection: formatSiswaSelection
        });
    });
</script>


{{-- Styling tambahan Select2 biar pas dengan Bootstrap --}}
<link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet">
@endpush
