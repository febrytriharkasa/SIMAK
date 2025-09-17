@extends('layouts.sbadmin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h5 class="m-0 font-weight-bold">Form Registrasi Pengguna</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">
                        @csrf

                        {{-- Nama --}}
                        <div class="form-group mb-3">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        {{-- NIP --}}
                        <div class="form-group mb-3">
                            <label for="nip">NIP</label>
                            <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-3">
                            <label for="email">Alamat Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        {{-- Role --}}
                        <div class="form-group mb-3">
                            <label for="role">Daftar Sebagai</label>
                            <select name="role" class="form-control" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="guru_mi" {{ old('role')=='guru_mi' ? 'selected' : '' }}>Guru MI</option>
                                <option value="guru_tk" {{ old('role')=='guru_tk' ? 'selected' : '' }}>Guru TK</option>
                                <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('login') }}" class="btn btn-secondary mr-2">Batal</a>
                            <button type="submit" class="btn btn-success">Daftar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
