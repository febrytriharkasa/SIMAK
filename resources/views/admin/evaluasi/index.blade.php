@extends('layouts.sbadmin')

@section('title', 'Daftar Evaluasi Kinerja')

@section('content')
<div class="container-fluid">
    <h3 class="mb-3 ms-3">Daftar Evaluasi Kinerja</h3>

    <a href="{{ route('evaluasi.create') }}" class="btn btn-primary mb-3">+ Tambah Evaluasi</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Periode</th>
                            <th>Nilai Akhir</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluasi as $key => $e)
                        <tr>
                            <td>{{ $evaluasi->firstItem() + $key }}</td>
                            <td>{{ $e->user->nip ?? '-' }}</td>
                            <td>{{ $e->user->name ?? '-' }}</td>
                            <td>{{ $e->periode }}</td>
                            <td>{{ $e->nilai_akhir }}</td>
                            <td>
                                <span class="badge 
                                    @if($e->kategori == 'Sangat Baik') bg-success 
                                    @elseif($e->kategori == 'Baik') bg-primary
                                    @elseif($e->kategori == 'Cukup') bg-warning
                                    @else bg-danger @endif">
                                    {{ $e->kategori }}
                                </span>
                            </td>
                            <td>{{ $e->deskripsi }}</td>
                            <td>
                                <a href="{{ route('admin.evaluasi.edit', $e->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('evaluasi.destroy', $e->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $evaluasi->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Optional: Jika ingin menambahkan highlight row saat hover
    document.querySelectorAll('table tbody tr').forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.backgroundColor = 'rgba(255,255,255,0.05)';
        });
        row.addEventListener('mouseleave', () => {
            row.style.backgroundColor = '';
        });
    });
</script>
@endpush
