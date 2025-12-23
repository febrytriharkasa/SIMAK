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

        th,
        td {
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

    @foreach($dataRapor as $rapor)
    <div class="title">
        RAPOR SEMENTARA<br>
        KELAS {{ $rapor['kelas']->nama_kelas }} - SEMESTER {{ strtoupper($rapor['semester']) }}
    </div>

    <table class="no-border">
        <tr>
            <td width="15%">Nama Siswa</td>
            <td width="70%">: {{ $siswa->nama }}</td>
            <td width="15%">Kelas</td>
            <td width="35%">: {{ $rapor['kelas']->nama_kelas }}</td>
        </tr>
        <tr>
            <td>Nomor Induk</td>
            <td>: {{ $siswa->nisn ?? '-' }}</td>
            <td>Semester</td>
            <td>: {{ ucfirst($rapor['semester']) }}</td>
        </tr>
    </table>

    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Pelajaran</th>
                <th>KKM</th>
                <th>Nilai Angka</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rapor['nilais'] as $i => $item)
            <tr>
                <td class="center">{{ $i + 1 }}</td>
                <td>{{ $item['mapel']->nama_mapel }}</td>
                <td class="center">{{ $item['mapel']->kkm ?? 75 }}</td>
                <td class="center">{{ $item['nilai_akhir'] ?? '-' }}</td>
                <td class="center">
                    @if(!is_null($item['nilai_akhir']))
                        {{ $item['nilai_akhir'] >= ($item['mapel']->kkm ?? 75) ? 'Tuntas' : 'Belum Tuntas' }}
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
    <br>
    {{-- Ringkasan absensi --}}
    <table>
        <tr>
            <th>Hadir</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Alfa</th>
        </tr>
        <tr class="center">
            <td>{{ $rapor['absensi']['hadir'] }}</td>
            <td>{{ $rapor['absensi']['izin'] }}</td>
            <td>{{ $rapor['absensi']['sakit'] }}</td>
            <td>{{ $rapor['absensi']['alfa'] }}</td>
        </tr>
    </table>
    <br>
    <table style="width:100%; border-collapse:collapse; margin-top:10px;">
        <tr>
            <td style="border:1px solid #000; padding:6px;" width="75%">Rata-rata</td>
            <td style="border:1px solid #000; padding:6px; text-align:center;" width="25%">{{ $rapor['rataRata'] }}</td>
        </tr>
        @if($rapor['semester'] === 'genap')
        <tr>
            <td style="border:1px solid #000; padding:6px;">Status Akademik</td>
            <td colspan="3" style="border:1px solid #000; padding:6px;"><strong>{{ $rapor['status'] }}</strong></td>
        </tr>
        @endif
    </table>

    <div style="page-break-after:always;"></div>
    @endforeach


</body>

</html>