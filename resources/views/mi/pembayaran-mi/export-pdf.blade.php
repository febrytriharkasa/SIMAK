<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran MI</title>
    <link rel="icon" href="{{ asset('download.png') }}" type="image/png">
    <style>
        body { font-family: sans-serif; font-size: 12px; }

        .kop-surat {
            display: table;
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 6px;
            margin-bottom: 15px;
        }
        .kop-logo {
            display: table-cell;
            width: 90px;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo img {
            width: 80px;
            height: 80px;
        }
        .kop-text {
            display: table-cell;
            text-align: left;
            vertical-align: middle;
        }
        .kop-text h2 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .kop-text p {
            margin: 2px 0;
            font-size: 11px;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <!-- Kop Surat -->
    <div class="kop-surat">
        <div class="kop-logo">
            <img src="{{ public_path('download.png') }}" alt="Logo">
        </div>
        <div class="kop-text">
            <h2>YAYASAN FAISAL</h2>
            <p><strong>Madrasah Ibtidaiyah</strong></p>
            <p>Jl. Contoh No. 123, Surabaya | Telp: (031) 123456</p>
        </div>
    </div>

    <!-- Judul -->
    <h3 style="text-align:center; margin: 0;">LAPORAN PEMBAYARAN SISWA</h3>
    <p style="text-align:center; margin: 0;">Bulan: {{ $bulan->translatedFormat('F Y') }}</p>
    <p style="text-align:right; font-size:11px;">Dicetak: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>

    <!-- Tabel -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>Tanggal Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaran as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->siswa->nisn ?? '-' }}</td>
                    <td>{{ $p->siswa->nama ?? '-' }}</td>
                    <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>{{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') : '-' }}</td>
                    <td>{{ ucfirst($p->status) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total (Lunas)</strong></td>
                <td colspan="3"><strong>
                    Rp {{ number_format($pembayaran->where('status', 'lunas')->sum('jumlah'), 0, ',', '.') }}
                </strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
