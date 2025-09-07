@extends('layouts.sbadmin')

@section('title', 'Edit Siswa TK')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Siswa TK</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa-tk.update', $siswa->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        {{-- No Induk --}}
                        <div class="mb-3">
                            <label for="id_tk" class="form-label fw-semibold">No Induk</label>
                            <input type="text" name="id_tk" id="id_tk" 
                                   class="form-control @error('id_tk') is-invalid @enderror" 
                                   value="{{ old('id_tk', $siswa->id_tk) }}">
                            @error('id_tk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama</label>
                            <input type="text" name="nama" id="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $siswa->nama) }}">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Tahun --}}
                        <div class="mb-3">
                            <label for="tahun" class="form-label fw-semibold">Tahun</label>
                            <input type="number" name="tahun" id="tahun" 
                                   class="form-control @error('tahun') is-invalid @enderror" 
                                   value="{{ old('tahun', $siswa->tahun) }}" placeholder="contoh: 2025">
                            @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Kelas --}}
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label fw-semibold">Kelas</label>
                            <select name="kelas_id" id="kelas_id" 
                                    class="form-select @error('kelas_id') is-invalid @enderror">
                                <option value="">-- Pilih Kelas (default: Kelas 1) --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}" 
                                        {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Nama Wali --}}
                        <div class="mb-3">
                            <label for="nama_wali" class="form-label fw-semibold">Nama Wali</label>
                            <input type="text" name="nama_wali" id="nama_wali" 
                                   class="form-control @error('nama_wali') is-invalid @enderror" 
                                   value="{{ old('nama_wali', $siswa->nama_wali) }}">
                            @error('nama_wali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- No HP Wali --}}
                        <div class="mb-3">
                            <label for="no_hp_wali" class="form-label fw-semibold">No HP Wali</label>
                            <input type="text" name="no_hp_wali" id="no_hp_wali" 
                                   class="form-control @error('no_hp_wali') is-invalid @enderror" 
                                   value="{{ old('no_hp_wali', $siswa->no_hp_wali) }}">
                            @error('no_hp_wali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat_siswa" class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat_siswa" id="alamat_siswa" rows="3" 
                                      class="form-control @error('alamat_siswa') is-invalid @enderror">{{ old('alamat_siswa', $siswa->alamat_siswa) }}</textarea>
                            @error('alamat_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2">
                                <i class="bi bi-check-circle"></i> Update
                            </button>
                            <a href="{{ route('siswa-tk.index') }}" class="btn btn-secondary">
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
