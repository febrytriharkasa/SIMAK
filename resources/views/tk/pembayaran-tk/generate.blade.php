@extends('layouts.sbadmin')

@section('title', 'Generate SPP')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Generate SPP</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('pembayaran-mi.generate-tk') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Pilih Kelas</label>
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($kelasList as $kelas)
                                    <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select" required>
                                @for($i=1;$i<=12;$i++)
                                    <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" value="{{ date('Y') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_default" class="form-label">Jumlah Default</label>
                            <input type="number" name="jumlah_default" id="jumlah_default" class="form-control" placeholder="Contoh: 150000" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Generate</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
