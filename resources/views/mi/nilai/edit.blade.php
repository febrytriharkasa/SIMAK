@extends('layouts.sbadmin')

@section('content')
<div class="container">
    <h3>Edit Nilai Siswa</h3>

    <form action="{{ route('nilai.update', $nilai->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Pilih Mapel --}}
        <div class="mb-3">
            <label for="mapel_id" class="form-label">Mata Pelajaran</label>
            <select name="mapel_id" id="mapel_id" class="form-select @error('mapel_id') is-invalid @enderror">
                <option value="">-- Pilih Mapel --</option>
                @foreach($mapelList as $mapel)
                    <option value="{{ $mapel->id }}" 
                        {{ old('mapel_id', $nilai->mapel_id) == $mapel->id ? 'selected' : '' }}>
                        {{ $mapel->nama }} (Guru: {{ $mapel->guru->nama ?? '-' }})
                    </option>
                @endforeach
            </select>
            @error('mapel_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Hidden siswa_id (biar ikut update) --}}
        <input type="hidden" name="siswa_id" value="{{ old('siswa_id', $nilai->siswa_id) }}">

        {{-- Hidden guru_id --}}
        <input type="hidden" name="guru_id" value="{{ old('guru_id', $nilai->guru_id) }}">

        {{-- Input Tugas (array JSON) --}}
        <div class="mb-3">
            <label class="form-label">Nilai Tugas</label>
            <div id="tugas-wrapper">
                @php 
                    $tugasList = old('tugas', $nilai->tugas ?? []);
                @endphp

                @foreach($tugasList as $i => $tugas)
                    <input type="number" name="tugas[]" value="{{ $tugas }}" 
                           class="form-control mb-2" placeholder="Nilai Tugas {{ $i+1 }}">
                @endforeach

                <input type="number" name="tugas[]" value="" class="form-control mb-2" placeholder="Tambah Nilai Tugas">
            </div>
            <button type="button" class="btn btn-sm btn-secondary" onclick="addTugas()">+ Tambah Tugas</button>
        </div>

        {{-- Input UTS --}}
        <div class="mb-3">
            <label for="uts" class="form-label">Nilai UTS</label>
            <input type="number" name="uts" id="uts" 
                   value="{{ old('uts', $nilai->uts) }}" 
                   class="form-control @error('uts') is-invalid @enderror">
            @error('uts')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Input UAS --}}
        <div class="mb-3">
            <label for="uas" class="form-label">Nilai UAS</label>
            <input type="number" name="uas" id="uas" 
                   value="{{ old('uas', $nilai->eas) }}" 
                   class="form-control @error('uas') is-invalid @enderror">
            @error('uas')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- Tombol --}}
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@section('scripts')
<script>
function addTugas() {
    let wrapper = document.getElementById('tugas-wrapper');
    let input = document.createElement('input');
    input.type = 'number';
    input.name = 'tugas[]';
    input.className = 'form-control mb-2';
    input.placeholder = 'Nilai Tugas';
    wrapper.appendChild(input);
}
</script>
@endsection
