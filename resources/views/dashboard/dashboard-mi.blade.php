@extends('layouts.sbadmin')

@section('title', 'Dashboard Guru MI')

@section('content')
<div class="page-heading mb-4">
    <h3 class="ms-4">Dashboard Guru MI 👨‍🏫</h3>
    <p class="ms-4">Ringkasan lengkap data MI.</p>
</div>

<div class="row ms-2 me-2">
    <!-- Jumlah Siswa -->
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Jumlah Siswa MI</h6>
                <h3>{{ $jumlahSiswaMi }}</h3>
            </div>
        </div>
    </div>

    <!-- Jumlah Guru -->
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Jumlah Guru MI</h6>
                <h3>{{ $jumlahGuruMi }}</h3>
            </div>
        </div>
    </div>

    <!-- Total Pembayaran -->
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Total Pembayaran</h6>
                <h3>Rp {{ number_format($totalPembayaranMi,0,',','.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Jumlah Transaksi -->
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Jumlah Transaksi</h6>
                <h3>{{ $jumlahTransaksiMi }}</h3>
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
                <canvas id="chartPembayaranMi"></canvas>
            </div>
        </div>
    </div>

    <!-- Grafik Transaksi per Bulan -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Transaksi per Bulan</div>
            <div class="card-body">
                <canvas id="chartTransaksiMi"></canvas>
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
                <canvas id="chartSiswaPerTahunMi"></canvas>
            </div>
        </div>
    </div>

    <!-- Grafik Guru per Mapel -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Jumlah Guru per Mapel</div>
            <div class="card-body">
                <canvas id="chartGuruPerMapelMi"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Pembayaran MI
    new Chart(document.getElementById('chartPembayaranMi'), {
        type: 'line',
        data: {
            labels: @json(range(1,12)),
            datasets: [{
                label: 'Total Pembayaran',
                data: @json($pembayaranPerBulanMi),
                borderColor: 'blue',
                fill: false
            }]
        }
    });

    // Chart Transaksi MI
    new Chart(document.getElementById('chartTransaksiMi'), {
        type: 'bar',
        data: {
            labels: @json(range(1,12)),
            datasets: [{
                label: 'Jumlah Transaksi',
                data: @json($transaksiPerBulanMi),
                backgroundColor: 'orange'
            }]
        }
    });

    // Chart Siswa per Tahun MI
    new Chart(document.getElementById('chartSiswaPerTahunMi'), {
        type: 'bar',
        data: {
            labels: @json(array_keys($jumlahSiswaPerTahunMi)),
            datasets: [{
                label: 'Jumlah Siswa',
                data: @json(array_values($jumlahSiswaPerTahunMi)),
                backgroundColor: 'green'
            }]
        }
    });

    // Chart Guru per Mapel MI
    new Chart(document.getElementById('chartGuruPerMapelMi'), {
        type: 'pie',
        data: {
            labels: @json(array_keys($jumlahGuruPerMapelMi)),
            datasets: [{
                data: @json(array_values($jumlahGuruPerMapelMi)),
                backgroundColor: ['red','blue','yellow','purple','cyan']
            }]
        }
    });
</script>
@endpush
