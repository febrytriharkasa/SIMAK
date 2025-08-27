@extends('layouts.sbadmin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Welcome, {{ Auth::user()->name }}</h1>

    <div class="row">
        {{-- Untuk Admin, tampilkan semua --}}
        @role('admin')
            <!-- Total Users -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Siswa MI -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Siswa MI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Siswa_MI::count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Guru MI -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Guru MI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Guru_MI::count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Pembayaran -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pembayaran MI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format(\App\Models\Pembayaran_MI::where('status', 'lunas')->sum('jumlah'), 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        {{-- Untuk Guru MI, hanya bisa melihat Siswa & Guru --}}
        @role('guru_mi')
            <!-- Total Siswa MI -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Siswa MI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Siswa_MI::count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Guru MI -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Guru MI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\Guru_MI::count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Total Pembayaran -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pembayaran MI</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format(\App\Models\Pembayaran_MI::where('status', 'lunas')->sum('jumlah'), 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        @endrole
    </div>
@endsection
