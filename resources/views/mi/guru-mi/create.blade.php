@extends('layouts.sbadmin')

@section('title', 'Tambah Guru MI')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Tambah Guru MI</h5>
                </div>
                <div class="card-body">
                    
                    {{-- Alert Error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('guru-tk.store') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">Nama</label>
                            <input type="text" name="nama" id="nama" 
                                   class="form-control @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama') }}">
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- NIP --}}
                        <div class="mb-3">
                            <label for="nip" class="form-label fw-semibold">NIP</label>
                            <input type="text" name="nip" id="nip" 
                                   class="form-control @error('nip') is-invalid @enderror" 
                                   value="{{ old('nip') }}">
                            @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Mata Pelajaran --}}
                        <div class="mb-3">
                            <label for="mapel" class="form-label fw-semibold">Mata Pelajaran</label>
                            <select name="mapel" id="mapel" 
                                    class="form-control @error('mapel') is-invalid @enderror">
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                <option value="Matematika" {{ old('mapel')=='Matematika' ? 'selected' : '' }}>Matematika</option>
                                <option value="Bahasa Indonesia" {{ old('mapel')=='Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                <option value="IPA" {{ old('mapel')=='IPA' ? 'selected' : '' }}>IPA</option>
                                <option value="IPS" {{ old('mapel')=='IPS' ? 'selected' : '' }}>IPS</option>
                                <option value="PKN" {{ old('mapel')=='PKN' ? 'selected' : '' }}>PKN</option>
                                <option value="Bahasa Arab" {{ old('mapel')=='Bahasa Arab' ? 'selected' : '' }}>Bahasa Arab</option>
                                <option value="Pendidikan Agama Islam" {{ old('mapel')=='Pendidikan Agama Islam' ? 'selected' : '' }}>Pendidikan Agama Islam</option>
                                <option value="PJOK" {{ old('mapel')=='PJOK' ? 'selected' : '' }}>PJOK</option>
                                <option value="Seni Budaya" {{ old('mapel')=='Seni Budaya' ? 'selected' : '' }}>Seni Budaya</option>
                            </select>
                            @error('mapel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- No HP --}}
                        <div class="mb-3">
                            <label for="no_hp_guru" class="form-label fw-semibold">No HP</label>
                            <input type="text" name="no_hp_guru" id="no_hp_guru" 
                                   class="form-control @error('no_hp_guru') is-invalid @enderror" 
                                   value="{{ old('no_hp_guru') }}">
                            @error('no_hp_guru') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="mb-3">
                            <label for="alamat_guru" class="form-label fw-semibold">Alamat</label>
                            <textarea name="alamat_guru" id="alamat_guru" rows="3" 
                                      class="form-control @error('alamat_guru') is-invalid @enderror">{{ old('alamat_guru') }}</textarea>
                            @error('alamat_guru') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success me-2">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                            <a href="{{ route('guru-mi.index') }}" class="btn btn-secondary">
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
