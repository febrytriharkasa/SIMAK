<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran MI</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 10px; font-size: 12px; }
        .kwitansi { width: 100%; border: 1px solid #000; padding: 10px; }
        .header { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 16px; }
        .details { margin-bottom: 10px; }
        .details table { width: 100%; font-size: 12px; }
        .details td { padding: 3px 0; }
        .footer { text-align: right; margin-top: 20px; font-size: 12px; }
        .jumlah { font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <div class="kwitansi">
        <div class="header">
            <h2>Kwitansi Pembayaran MI</h2>
            <p>No: {{ $pembayaran->id }}/{{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('Y') }}</p>
        </div>

        <div class="details">
            <table>
                <tr>
                    <td>Telah Terima Dari</td>
                    <td>: {{ $pembayaran->siswa->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <td>NISN</td>
                    <td>: {{ $pembayaran->siswa->nisn ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jumlah Pembayaran</td>
                    <td class="jumlah">: Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($pembayaran->tanggal)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: {{ ucfirst($pembayaran->status) }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            Mojokerto, {{ \Carbon\Carbon::now()->format('d-m-Y') }}<br><br><br>
            <u>{{ Auth::user()->name }}</u> {{-- 🔥 User login --}}
        </div>
    </div>
</body>
</html>
