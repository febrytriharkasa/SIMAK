<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Siswa</title>
</head>
<body>
    <h3>Halo Wali dari {{ $absensi->siswa->nama }}</h3>

    <p>Berikut informasi absensi siswa pada tanggal {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d-m-Y') }}:</p>

    <ul>
        <li>Status: <strong>{{ ucfirst($absensi->status) }}</strong></li>
        @if($absensi->keterangan)
            <li>Keterangan: {{ $absensi->keterangan }}</li>
        @endif
        <li>Kelas: {{ $absensi->siswa->kelas->nama_kelas ?? '-' }}</li>
    </ul>

    <p>Terima kasih.</p>
</body>
</html>
