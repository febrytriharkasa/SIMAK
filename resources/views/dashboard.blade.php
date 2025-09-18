@extends('layouts.sbadmin')

@section('title', 'Dashboard')

@section('content')
<style>
/* Light mode */
[data-bs-theme="light"] #content-wrapper,
[data-bs-theme="light"] .container-fluid {
    background-color: #FFFFFFFF !important; 
    color: #181515;
}

/* Dark mode */
[data-bs-theme="dark"] #content-wrapper,
[data-bs-theme="dark"] .container-fluid {
    background-color: #1B1B1DFF !important; 
    color: #fff;
}
</style> 
    
<div class="page-heading mb-40">
    <h3 class="ms-5">Dashboard Statistik</h3>
</div>

@hasanyrole('admin|guru_mi')
{{-- ================= MI ================= --}}
<h4 class="mb-3 ms-2">📘 Manajemen MI</h4>
<div class="row">
    <!-- Statistik Cards MI -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Jumlah Siswa MI</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahSiswaMi ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-success text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-person-badge-fill fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Jumlah Guru MI</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahGuruMi ?? 0}}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-danger text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-cash-coin fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Pembayaran MI</h6>
                    <h4 class="fw-bold mb-0">Rp {{ number_format($totalPembayaranMi ?? 0 ,0,',','.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-info text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-receipt fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Jumlah Transaksi MI</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahTransaksiMi ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart MI --}}
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Pembayaran MI Per Bulan</h5></div>
            <div class="card-body"><div id="chart-pembayaran-mi"></div></div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Transaksi MI Per Bulan</h5></div>
            <div class="card-body"><div id="chart-transaksi-mi"></div></div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Siswa MI Per Tahun</h5></div>
            <div class="card-body"><div id="chart-siswa-mi"></div></div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Guru MI Per Mapel</h5></div>
            <div class="card-body"><div id="chart-guru-mi"></div></div>
        </div>
    </div>
</div>
@endhasanyrole

@hasanyrole('admin|guru_tk')
{{-- ================= TK ================= --}}
<h4 class="mb-3 ms-2">📗 Manajemen TK</h4>
<div class="row">
    <!-- Statistik Cards TK -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Jumlah Siswa TK</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahSiswaTk ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-success text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-person-badge-fill fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Jumlah Guru TK</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahGuruTk ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-danger text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-cash-coin fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Pembayaran TK</h6>
                    <h4 class="fw-bold mb-0">Rp {{ number_format($totalPembayaranTk ?? 0 ,0,',','.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 bg-info text-white rounded-circle d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                    <i class="bi bi-receipt fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Jumlah Transaksi TK</h6>
                    <h4 class="fw-bold mb-0">{{ $jumlahTransaksiTk ?? 0 }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart TK --}}
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Pembayaran TK Per Bulan</h5></div>
            <div class="card-body"><div id="chart-pembayaran-tk"></div></div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Transaksi TK Per Bulan</h5></div>
            <div class="card-body"><div id="chart-transaksi-tk"></div></div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Siswa TK Per Tahun</h5></div>
            <div class="card-body"><div id="chart-siswa-tk"></div></div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm rounded-4">
            <div class="card-header"><h5 class="fw-bold mb-0">Guru TK Per Mapel</h5></div>
            <div class="card-body"><div id="chart-guru-tk"></div></div>
        </div>
    </div>
</div>
@endhasanyrole

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    // ================= MI =================
    new ApexCharts(document.querySelector("#chart-pembayaran-mi"), { 
        series:[{ name: 'Pembayaran MI', data: @json($pembayaranPerBulanMi ?? 0) }],
        chart:{ type: 'bar', height: 350 },
        xaxis:{ categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        colors:['#435ebe']
    }).render();

    new ApexCharts(document.querySelector("#chart-transaksi-mi"), {
        series:[{ name: 'Transaksi MI', data: @json($transaksiPerBulanMi ?? 0) }],
        chart:{ type: 'line', height: 350 },
        xaxis:{ categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        colors:['#f39c12']
    }).render();

    new ApexCharts(document.querySelector("#chart-siswa-mi"), {
        series: Object.values(@json($jumlahSiswaPerTahunMi ?? 0 )),
        chart:{ type: 'donut', height: 350 },
        labels: Object.keys(@json($jumlahSiswaPerTahunMi ?? 0 )),
    }).render();

    new ApexCharts(document.querySelector("#chart-guru-mi"), {
        series: Object.values(@json($jumlahGuruPerMapelMi ?? 0 )),
        chart:{ type: 'pie', height: 350 },
        labels: Object.keys(@json($jumlahGuruPerMapelMi ?? 0)),
    }).render();

    // ================= TK =================
    new ApexCharts(document.querySelector("#chart-pembayaran-tk"), {
        series:[{ name: 'Pembayaran TK', data: @json($pembayaranPerBulanTk ?? 0 ) }],
        chart:{ type: 'bar', height: 350 },
        xaxis:{ categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        colors:['#3498db']
    }).render();

    new ApexCharts(document.querySelector("#chart-transaksi-tk"), {
        series:[{ name: 'Transaksi TK', data: @json($transaksiPerBulanTk ?? 0 ) }],
        chart:{ type: 'line', height: 350 },
        xaxis:{ categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'] },
        colors:['#2ecc71']
    }).render();

    new ApexCharts(document.querySelector("#chart-siswa-tk"), {
        series: Object.values(@json($jumlahSiswaPerTahunTk ?? 0 )),
        chart:{ type: 'donut', height: 350 },
        labels: Object.keys(@json($jumlahSiswaPerTahunTk ?? 0 )),
    }).render();

    new ApexCharts(document.querySelector("#chart-guru-tk"), {
        series: Object.values(@json($jumlahGuruPerMapelTk ?? 0 )),
        chart:{ type: 'pie', height: 350 },
        labels: Object.keys(@json($jumlahGuruPerMapelTk ?? 0 )),
    }).render();
</script>
@endpush