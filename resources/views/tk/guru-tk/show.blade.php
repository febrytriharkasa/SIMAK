@extends('layouts.sbadmin')

@section('title', 'Detail Guru TK')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Detail Guru</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">NIP</th>
                            <td>{{ $guru->nip }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $guru->nama }}</td>
                        </tr>
                        <tr>
                            <th>Mata Pelajaran</th>
                            <td>
                                @if($guru->mapels->isNotEmpty())
                                    {{ $guru->mapels->pluck('nama_mapel')->join(', ') }}
                                @else
                                    <em>-</em>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>{{ $guru->no_hp_guru }}</td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $guru->alamat_guru }}</td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('guru-tk.edit', $guru->id) }}" class="btn btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('guru-tk.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger me-2">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                        <a href="{{ route('guru-tk.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
