<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Siswa TK</title>
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/png">
</head>
<body>
<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f8;
    }
    .container {
        width: 500px;
        margin: 40px auto;
        background: #ffffff;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h3 { text-align: center; margin-bottom: 20px; }
    input, textarea { width: 100%; padding: 10px; margin-bottom: 12px; border-radius: 5px; border: 1px solid #ccc; }
    button { width: 100%; padding: 10px; background: #0d6efd; color: white; border: none; border-radius: 5px; cursor: pointer; }
    button:hover { background: #0b5ed7; }
    .success { color: green; margin-bottom: 10px; }
    .error { color: red; margin-bottom: 10px; }
    .error ul { padding-left: 18px; }
    .form-group { margin-bottom: 12px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 4px; }
    .file-note { display: block; font-size: 12px; color: #6c757d; margin-top: 4px; }
</style>

<div class="container">
    <h3>Form Pendaftaran Siswa TK</h3>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error --}}
    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pendaftaran.tk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="nama" placeholder="Nama Siswa" required>
        <input type="number" name="tahun" placeholder="Tahun Masuk" required>
        <input type="text" name="nama_wali" placeholder="Nama Wali" required>
        <input type="text" name="no_hp_wali" placeholder="No HP Wali" required>
        <input type="email" name="email" placeholder="Email Siswa/Wali" required>
        <textarea name="alamat_siswa" placeholder="Alamat Siswa" rows="3" required></textarea>

        <div class="form-group">
            <label for="bukti_pembayaran">Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*,.pdf" required>
            <small class="file-note">Upload bukti pembayaran (JPG, PNG, atau PDF). Maksimal 5 MB.</small>
        </div>

        <div class="form-group">
            <label for="kk">Kartu Keluarga (KK)</label>
            <input type="file" name="kk" id="kk" accept="image/*,.pdf" required>
            <small class="file-note">Upload KK (JPG, PNG, atau PDF). Maksimal 5 MB.</small>
        </div>

        <div class="form-group">
            <label for="akte">Akte Kelahiran</label>
            <input type="file" name="akte" id="akte" accept="image/*,.pdf" required>
            <small class="file-note">Upload Akte (JPG, PNG, atau PDF). Maksimal 5 MB.</small>
        </div>

        <div class="form-group">
            <label for="foto_siswa">Foto 3x4</label>
            <input type="file" name="foto_siswa" id="foto_siswa" accept="image/*" required>
            <small class="file-note">Upload Foto 3x4 (JPG atau PNG). Maksimal 2 MB.</small>
        </div>

        <button type="submit">Daftar</button>
    </form>
</div>
</body>
</html>
