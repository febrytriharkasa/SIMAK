@extends('layouts.sbadmin')

@section('title', 'Dashboard Guru TK')

@section('content')
<div class="page-heading mb-4">
    <h3 class="ms-4">Dashboard Guru TK 🧒</h3>
    <p class="ms-4">Ringkasan lengkap data TK.</p>
</div>

<div class="row ms-2 me-2">
    <!-- Jumlah Siswa -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Jumlah Siswa TK</h6>
                <h3>{{ $jumlahSiswaTk }}</h3>
            </div>
        </div>
    </div>

    <!-- Jumlah Guru -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Jumlah Guru TK</h6>
                <h3>{{ $jumlahGuruTk }}</h3>
            </div>
        </div>
    </div>

    <!-- Total Pembayaran -->
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Total Pembayaran</h6>
                <h3>Rp {{ number_format($totalPembayaranTk,0,',','.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Jumlah Transaksi -->
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Jumlah Transaksi</h6>
                <h3>{{ $jumlahTransaksiTk }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row ms-2 me-2 mt-4">
    <!-- Grafik Pembayaran per Bulan -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Pembayaran per Bulan</div>
            <div class="card-body">
                <canvas id="chartPembayaranTk"></canvas>
            </div>
        </div>
    </div>

    <!-- Grafik Transaksi per Bulan -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Transaksi per Bulan</div>
            <div class="card-body">
                <canvas id="chartTransaksiTk"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row ms-2 me-2 mt-4">
    <!-- Grafik Siswa per Tahun -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Jumlah Siswa per Tahun</div>
            <div class="card-body">
                <canvas id="chartSiswaPerTahunTk"></canvas>
            </div>
        </div>
    </div>

    <!-- Grafik Guru per Mapel -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Jumlah Guru per Mapel</div>
            <div class="card-body">
                <canvas id="chartGuruPerMapelTk"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Pembayaran TK
    new Chart(document.getElementById('chartPembayaranTk'), {
        type: 'line',
        data: {
            labels: @json(range(1,12)),
            datasets: [{
                label: 'Total Pembayaran',
                data: @json($pembayaranPerBulanTk),
                borderColor: 'blue',
                fill: false
            }]
        }
    });

    // Chart Transaksi TK
    new Chart(document.getElementById('chartTransaksiTk'), {
        type: 'bar',
        data: {
            labels: @json(range(1,12)),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: @json($transaksiPerBulanTk),
                backgroundColor: 'orange'
            }]
        }
    });

    // Chart Siswa per Tahun TK
    new Chart(document.getElementById('chartSiswaPerTahunTk'), {
        type: 'bar',
        data: {
            labels: @json(array_keys($jumlahSiswaPerTahunTk)),
            datasets: [{
                label: 'Jumlah Siswa',
                data: @json(array_values($jumlahSiswaPerTahunTk)),
                backgroundColor: 'green'
            }]
        }
    });

    // Chart Guru per Mapel TK
    new Chart(document.getElementById('chartGuruPerMapelTk'), {
        type: 'pie',
        data: {
            labels: @json(array_keys($jumlahGuruPerMapelTk)),
            datasets: [{
                data: @json(array_values($jumlahGuruPerMapelTk)),
                backgroundColor: ['red','blue','yellow','purple','cyan']
            }]
        }
    });
</script>
@endpush
