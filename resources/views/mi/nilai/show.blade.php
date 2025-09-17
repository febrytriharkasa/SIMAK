@extends('layouts.sbadmin')

@section('title', 'Detail Nilai Siswa MI')

@section('content')
<div class="container">
    <h3 class = "ms-5">Nilai Siswa: {{ $nilaiSiswa->first()->siswa->nama ?? '-' }}</h3>
    <a href="{{ route('nilai.index') }}" class="btn btn-secondary mb-3 ms-5">Kembali</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Mapel</th>
                <th>Guru</th>
                <th>Tugas</th>
                <th>UTS</th>
                <th>EAS</th>
                <th>Nilai Akhir</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilaiSiswa as $nilai)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $nilai->mapel->nama_mapel }}</td>
                    <td>{{ $nilai->guru->nama }}</td>
                    <td>{{ implode(', ', $nilai->tugas ?? []) }}</td>
                    <td>{{ $nilai->uts }}</td>
                    <td>{{ $nilai->eas }}</td>
                    <td>{{ $nilai->nilai_akhir }}</td>
                    <td class="text-center">
                        <!-- Tombol Edit -->
                        <a href="{{ route('nilai.edit', $nilai->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <!-- Tombol Delete -->
                        <form action="{{ route('nilai.destroy', $nilai->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus nilai ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
