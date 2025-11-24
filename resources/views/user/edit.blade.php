@extends('layouts.sbadmin')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Profil Saya</h3>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success">Profil berhasil diperbarui.</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <!-- Avatar -->
        <div class="mb-3">
            <label for="avatar" class="form-label">Foto Profil</label><br>
            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=435ebe&color=fff' }}" 
                 alt="Avatar" class="rounded-circle mb-2" width="100" height="100">
            <input type="file" name="avatar" id="avatar" class="form-control" accept="image/*">
            @error('avatar')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Nama -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection