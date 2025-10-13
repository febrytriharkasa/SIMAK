@extends('layouts.sbadmin')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Profil Saya</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-body row">
            <div class="col-md-3 text-center">
                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=435ebe&color=fff' }}" 
                     alt="Foto" class="img-fluid rounded mb-3">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Edit Profil</a>
            </div>

            <div class="col-md-9">
                <table class="table table-borderless">
                    <tr>
                        <th>NIP</th>
                        <td>{{ Auth::user()->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td>{{ Auth::user()->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>{{ Auth::user()->tempat_lahir ?? '-' }}, {{ Auth::user()->tanggal_lahir ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ Auth::user()->jenis_kelamin ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Agama</th>
                        <td>{{ Auth::user()->agama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ Auth::user()->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Mata Pelajaran</th>
                        <td>{{ Auth::user()->mata_pelajaran ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kelas Diampu</th>
                        <td>{{ Auth::user()->kelas_diampu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jabatan</th>
                        <td>{{ Auth::user()->jabatan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ Auth::user()->tanggal_masuk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pendidikan</th>
                        <td>{{ Auth::user()->pendidikan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status Kepegawaian</th>
                        <td>{{ Auth::user()->status_kepegawaian ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
