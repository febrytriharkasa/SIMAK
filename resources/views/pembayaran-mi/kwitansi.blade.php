<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .kwitansi { width: 600px; margin: auto; border: 1px solid #000; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .details { margin-bottom: 20px; }
        .details table { width: 100%; }
        .details td { padding: 5px 0; }
        .footer { text-align: right; margin-top: 40px; }
        .jumlah { font-weight: bold; font-size: 18px; }
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
            Mojokerto, {{ \Carbon\Carbon::now()->format('d-m-Y') }}<br>
            <br><br><br>
            <u>Petugas</u>
        </div>
    </div>

    <script>
        // Otomatis print saat terbuka
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
