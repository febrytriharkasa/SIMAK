@extends('layouts.sbadmin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Selamat Datang, {{ Auth::user()->name }}</h1>

    <div class="row">
        {{-- ADMIN --}}
        @role('admin')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-primary text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div>
                            <div class="small text-uppercase">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold">{{ \App\Models\User::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <div>
                            <div class="small text-uppercase">Siswa MI</div>
                            <div class="h5 mb-0 font-weight-bold">{{ \App\Models\Siswa_MI::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-info text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <div>
                            <div class="small text-uppercase">Guru MI</div>
                            <div class="h5 mb-0 font-weight-bold">{{ \App\Models\Guru_MI::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-warning text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                        <div>
                            <div class="small text-uppercase">Pembayaran MI</div>
                            <div class="h5 mb-0 font-weight-bold">
                                Rp {{ number_format(\App\Models\Pembayaran_MI::where('status','lunas')->sum('jumlah'), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TK --}}
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                        <div>
                            <div class="small text-uppercase">Siswa TK</div>
                            <div class="h5 mb-0 font-weight-bold">{{ \App\Models\SiswaTk::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-info text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <div>
                            <div class="small text-uppercase">Guru TK</div>
                            <div class="h5 mb-0 font-weight-bold">{{ \App\Models\GuruTk::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-warning text-white">
                    <div class="card-body d-flex align-items-center">
                        <div class="mr-3">
                            <i class="fas fa-coins fa-2x"></i>
                        </div>
                        <div>
                            <div class="small text-uppercase">Pembayaran TK</div>
                            <div class="h5 mb-0 font-weight-bold">
                                Rp {{ number_format(\App\Models\PembayaranTk::where('status','lunas')->sum('jumlah'), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        {{-- GURU MI --}}
        @role('guru_mi')
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-graduate fa-2x mr-3"></i>
                        <div>
                            <div class="small">Siswa MI</div>
                            <div class="h5 mb-0">{{ \App\Models\Siswa_MI::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-info text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-chalkboard-teacher fa-2x mr-3"></i>
                        <div>
                            <div class="small">Guru MI</div>
                            <div class="h5 mb-0">{{ \App\Models\Guru_MI::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-warning text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-coins fa-2x mr-3"></i>
                        <div>
                            <div class="small">Pembayaran MI</div>
                            <div class="h5 mb-0">
                                Rp {{ number_format(\App\Models\Pembayaran_MI::where('status','lunas')->sum('jumlah'), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

        {{-- GURU TK --}}
        @role('guru_tk')
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-success text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-user-graduate fa-2x mr-3"></i>
                        <div>
                            <div class="small">Siswa TK</div>
                            <div class="h5 mb-0">{{ \App\Models\SiswaTk::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-info text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-chalkboard-teacher fa-2x mr-3"></i>
                        <div>
                            <div class="small">Guru TK</div>
                            <div class="h5 mb-0">{{ \App\Models\GuruTk::count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card shadow border-0 rounded-lg bg-gradient-warning text-white">
                    <div class="card-body d-flex align-items-center">
                        <i class="fas fa-coins fa-2x mr-3"></i>
                        <div>
                            <div class="small">Pembayaran TK</div>
                            <div class="h5 mb-0">
                                Rp {{ number_format(\App\Models\PembayaranTk::where('status','lunas')->sum('jumlah'), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
    </div>
@endsection
