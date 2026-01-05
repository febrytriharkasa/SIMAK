<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Siswa MI</title>
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/png">
</head>
<body>

<style>
    body {
    font-family: 'Segoe UI', Tahoma, sans-serif;
    background: linear-gradient(135deg, #e9f0ff, #f9fbff);
    min-height: 100vh;
    margin: 0;
    padding: 40px 16px;
}


    .container {
    max-width: 520px;
    width: 100%;
    margin: 0 auto;
    background: #ffffff;
    padding: 100px;
    border-radius: 12px;
    box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}


    h3 {
        text-align: center;
        margin-bottom: 8px;
        color: #0d6efd;
    }

    .subtitle {
        text-align: center;
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 25px;
    }

    .section-title {
        margin-top: 25px;
        margin-bottom: 10px;
        font-size: 15px;
        font-weight: 600;
        color: #084298;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 6px;
    }

    input, textarea, select {
        width: 100%;
        padding: 11px 12px;
        margin-bottom: 14px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    input:focus,
    textarea:focus,
    select:focus {
        border-color: #0d6efd;
        outline: none;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.15);
    }

    textarea {
        resize: vertical;
    }

    .form-group {
        margin-bottom: 14px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 5px;
        color: #343a40;
    }

    .file-note {
        display: block;
        font-size: 12px;
        color: #6c757d;
        margin-top: 4px;
    }

    button {
        width: 100%;
        padding: 12px;
        background: linear-gradient(135deg, #0d6efd, #084298);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-top: 10px;
    }

    button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(13,110,253,0.35);
    }

    .success {
        background: #d1e7dd;
        color: #0f5132;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .error {
        background: #f8d7da;
        color: #842029;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .error ul {
        padding-left: 18px;
        margin: 0;
    }
</style>

<div class="container">
    <h3>Form Pendaftaran Siswa MI</h3>
    <div class="subtitle">Silakan isi data dengan lengkap dan benar</div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pendaftaran.mi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- DATA SISWA -->
        <div class="section-title">Data Siswa</div>
        <input type="text" name="nama" placeholder="Nama Siswa" required>
        <input type="date" name="tanggal_lahir" placeholder="Tanggal Lahir Siswa" required>

        <!-- Tambahkan jenis kelamin -->
        <select name="jenis_kelamin" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>

        <input type="number" name="tahun" placeholder="Tahun Masuk" required>
        <textarea name="alamat_siswa" placeholder="Alamat Siswa" rows="3" required></textarea>
        <input type="email" name="email" placeholder="Email orang tua / Wali" required>

        <!-- DATA ORANG TUA KANDUNG -->
        <div class="section-title">Data Orang Tua Kandung</div>

        <input type="text" name="nama_ayah" placeholder="Nama Lengkap Ayah" required>
        <input type="text" name="nama_ibu" placeholder="Nama Lengkap Ibu" required>

        <textarea name="alamat_orangtua" placeholder="Alamat Orang Tua" rows="3" required></textarea>

        <input type="text" name="no_hp_orangtua" placeholder="No Telepon Orang Tua" required>

        <input type="text" name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" required>
        <input type="text" name="pekerjaan_ibu" placeholder="Pekerjaan Ibu" required>

        <input type="text" name="pendidikan_ayah" placeholder="Pendidikan Terakhir Ayah" required>
        <input type="text" name="pendidikan_ibu" placeholder="Pendidikan Terakhir Ibu" required>

        <input type="text" name="penghasilan_ayah" placeholder="Penghasilan Ayah / Bulan (contoh: 2500000)">
        <input type="text" name="penghasilan_ibu" placeholder="Penghasilan Ibu / Bulan (contoh: 2000000)">


        <!-- DATA WALI -->
        <div class="section-title">Data Wali</div>
        <input type="text" name="nama_wali" placeholder="Nama Wali" >
        <input type="text" name="no_hp_wali" placeholder="No HP Wali" >
        <small class="text-muted">Jika tidak ada wali, bisa dikosongi atau isi dengan tanda "-"</small>        

        <!-- BERKAS -->
        <div class="section-title">Berkas Persyaratan</div>

        <div class="form-group">
            <label>Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" accept="image/*,.pdf" required>
            <small class="file-note">JPG, PNG, atau PDF • Maks. 5 MB</small>
        </div>

        <div class="form-group">
            <label>Kartu Keluarga (KK)</label>
            <input type="file" name="kk" accept="image/*,.pdf" required>
            <small class="file-note">JPG, PNG, atau PDF • Maks. 5 MB</small>
        </div>

        <div class="form-group">
            <label>Akte Kelahiran</label>
            <input type="file" name="akte" accept="image/*,.pdf" required>
            <small class="file-note">JPG, PNG, atau PDF • Maks. 5 MB</small>
        </div>

        <div class="form-group">
            <label>Foto Siswa 3x4</label>
            <input type="file" name="foto_siswa" accept="image/*" required>
            <small class="file-note">JPG atau PNG • Maks. 2 MB</small>
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>
</div>

</body>
</html>
