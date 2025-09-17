<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akun Disetujui</title>
</head>
<body>
    <h2>Halo {{ $name }},</h2>
    <p>Akun Anda telah disetujui oleh admin. Berikut detail login Anda:</p>
    <ul>
        <li><b>Email:</b> {{ $email }}</li>
        <li><b>Password:</b> {{ $password }}</li>
    </ul>
    <p>Silakan login menggunakan email dan password di atas.</p>
    <br>
    <p>Terima kasih,<br>Admin SIMAK</p>
</body>
</html>