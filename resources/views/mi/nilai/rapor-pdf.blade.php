<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 11px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            text-align: center;
            font-weight: bold;
        }

        .no-border td {
            border: none;
            padding: 2px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>

<div class="title">
    DAFTAR NILAI SEMESTER {{ strtoupper($semester) }} (RAPOR SEMENTARA)<br>
    TAHUN PELAJARAN {{ date('Y') }}/{{ date('Y') + 1 }}
</div>

<table class="no-border">
    <tr>
        <td width="15%">Nama Siswa</td>
        <td width="70%">: {{ $siswa->nama }}</td>
        <td width="15%">Kelas</td>
        <td width="35%">: {{ $siswa->kelas->nama_kelas }}</td>
    </tr>
    <tr>
        <td>Nomor Induk</td>
        <td>: {{ $siswa->nisn ?? '-' }}</td>
        <td>Semester</td>
        <td>: {{ ucfirst($semester) }}</td>
    </tr>
</table>

<br>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="45%">Mata Pelajaran</th>
            <th width="10%">KKM</th>
            <th width="15%">Nilai Angka</th>
            <th width="25%">Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mapels as $i => $mapel)
            @php
                $nilai = $nilais->firstWhere('mapel_id', $mapel->id);
                $angka = $nilai ? $nilai->nilai_akhir : null;
            @endphp
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $mapel->nama_mapel }}</td>
                <td class="center">{{ $mapel->kkm ?? 75 }}</td>
                <td class="center">{{ $angka ?? '-' }}</td>
                <td>
                    @if($angka)
                        {{ $angka >= ($mapel->kkm ?? 75) ? 'Tuntas' : 'Belum Tuntas' }}
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>

<table style="width:100%; border-collapse:collapse; margin-top:15px;">
    <tr>
        <td style="border:1px solid #000; padding:6px;" width="75%">
            Rata-rata
        </td>
        <td style="border:1px solid #000; padding:6px; text-align:center;" width="25%">
            {{ $rataRata }}
        </td>
    </tr>

    @if($semester === 'genap')
    <tr>
        <td style="border:1px solid #000; padding:6px;">
            Status Akademik
        </td>
        <td colspan="3" style="border:1px solid #000; padding:6px;">
            <strong>{{ $status }}</strong>
        </td>
    </tr>
    @endif
</table>


</body>
</html>
