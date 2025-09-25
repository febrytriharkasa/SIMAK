@extends('layouts.sbadmin')

@section('title', 'Evaluasi Kinerja')

@section('content')
    {{-- ===================== CSS Custom (Light & Dark Mode) ===================== --}}
    <style>
        /* Light mode */
        [data-bs-theme="light"] #content-wrapper,
        [data-bs-theme="light"] .container-fluid {
            background-color: #fff !important;
            color: #181515;
        }

        /* Dark mode */
        [data-bs-theme="dark"] #content-wrapper,
        [data-bs-theme="dark"] .container-fluid {
            background-color: #1B1B1DFF !important;
            color: #fff;
        }
    </style>

    {{-- ===================== Heading & Action Button ===================== --}}
    <div class="page-heading mb-4 d-flex justify-content-between align-items-center">
        <h3 class="ms-3">📊 Evaluasi Kinerja</h3>
        <a href="{{ route('evaluasi.create') }}" class="btn btn-primary me-3">
            <i class="bi bi-plus-circle me-1"></i> Tambah Evaluasi
        </a>
    </div>

    {{-- ===================== Statistik Evaluasi ===================== --}}
    <div class="row">
        {{-- Total Evaluasi --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-primary text-white rounded-circle d-flex justify-content-center align-items-center"
                        style="width:50px;height:50px;">
                        <i class="bi bi-person-badge-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Evaluasi</h6>
                        <h4 class="fw-bold mb-0">{{ $totalEvaluasi ?? 0 }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Rata-rata Nilai --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-success text-white rounded-circle d-flex justify-content-center align-items-center"
                        style="width:50px;height:50px;">
                        <i class="bi bi-graph-up-arrow fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Rata-rata Nilai</h6>
                        <h4 class="fw-bold mb-0">{{ number_format($rataNilai ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kategori Terbanyak --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-warning text-white rounded-circle d-flex justify-content-center align-items-center"
                        style="width:50px;height:50px;">
                        <i class="bi bi-award-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Kategori Terbanyak</h6>
                        <h4 class="fw-bold mb-0">{{ $kategoriTerbanyak ?? '-' }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Periode Terbaru --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 bg-info text-white rounded-circle d-flex justify-content-center align-items-center"
                        style="width:50px;height:50px;">
                        <i class="bi bi-calendar-event-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Periode Terbaru</h6>
                        <h4 class="fw-bold mb-0">{{ $periodeTerbaru ?? '-' }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== Tabel Evaluasi ===================== --}}
    <div class="card shadow-sm rounded-4">
        <div class="card-header">
            <h5 class="fw-bold mb-0">Daftar Evaluasi</h5>
        </div>
        <div class="card-body">
            {{-- Alert Success --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Table --}}
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
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
                            <td class="text-center">{{ $evaluasi->firstItem() + $key }}</td>
                            <td>{{ $e->user->nip ?? '-' }}</td>
                            <td>{{ $e->user->name ?? '-' }}</td>
                            <td class="text-center">{{ $e->periode }}</td>
                            <td class="text-center">{{ $e->nilai_akhir }}</td>
                            <td class="text-center">
                                <span class="badge 
                                    @if($e->kategori == 'Sangat Baik') bg-success 
                                    @elseif($e->kategori == 'Baik') bg-primary
                                    @elseif($e->kategori == 'Cukup') bg-warning
                                    @else bg-danger @endif">
                                    {{ $e->kategori }}
                                </span>
                            </td>
                            <td>{{ $e->deskripsi }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.evaluasi.edit', $e->id) }}"
                                    class="btn btn-sm btn-warning">Edit</a>
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

            {{-- Pagination --}}
            <div class="d-flex justify-content-end">
                {{ $evaluasi->links() }}
            </div>
        </div>
    </div>

    {{-- ===================== Chart Evaluasi ===================== --}}
    <div class="row mt-4">
        {{-- Chart Distribusi Kategori --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Distribusi Kategori</h5>
                </div>
                <div class="card-body">
                    <div id="chart-kategori"></div>
                </div>
            </div>
        </div>

        {{-- Chart Nilai Rata-rata per Periode --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm rounded-4">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Nilai Rata-rata per Periode</h5>
                </div>
                <div class="card-body">
                    <div id="chart-periode"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- ===================== Script Chart ===================== --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Chart Kategori
        new ApexCharts(document.querySelector("#chart-kategori"), {
            series: Object.values(@json($chartKategori ?? [])),
            chart: { type: 'pie', height: 350 },
            labels: Object.keys(@json($chartKategori ?? [])),
        }).render();

        // Chart Periode
        new ApexCharts(document.querySelector("#chart-periode"), {
            series: [{ name: 'Rata-rata Nilai', data: Object.values(@json($chartPeriode ?? [])) }],
            chart: { type: 'bar', height: 350 },
            xaxis: { categories: Object.keys(@json($chartPeriode ?? [])) },
            colors: ['#435ebe']
        }).render();
    </script>
@endpush
