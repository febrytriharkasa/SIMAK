<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Akun Orang Tua SIMAK</title>
</head>
<body>
    <h3>Yth. Orang Tua/Wali {{ $siswa->nama }}</h3>

    <p>Pendaftaran siswa <strong>{{ $siswa->nama }}</strong> telah <b>DISETUJUI</b>.</p>

    <p>Berikut akun Anda untuk login ke Sistem Informasi Akademik (SIMAK):</p>

    <ul>
        <li><b>Username:</b> {{ $siswa->nisn }}</li>
        <li><b>Password:</b> {{ $password }}</li>
    </ul>

    <p>Silakan login dan segera ganti password Anda.</p>

    <p>Terima kasih.</p>
    <p><b>Admin SIMAK</b></p>
</body>
</html>
