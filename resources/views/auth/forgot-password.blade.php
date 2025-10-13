<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - SIMAK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    html, body {
        height: 100%;
    }
    body {
        display: flex;
        flex-direction: column;
    }
    .content {
        flex: 1;
        display: flex;
        justify-content: center; /* horizontal center */
        align-items: center;     /* vertical center */
        padding: 20px;
    }
    .card {
        width: 100%;
        max-width: 600px; /* Lebar card lebih besar */
    }
</style>

</head>
<body class="bg-light">

    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">SIMAK</a>
        </div>
    </nav>

    <!-- Konten Forgot Password -->
    <div class="container content">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0y">Forgot Password</h5>
            </div>
            <div class="card-body">
                <!-- Alert sukses -->
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <!-- Alert error -->
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('forgot-password.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('login') }}" class="btn btn-secondary">Kembali ke Login</a>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer tetap di bawah -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        &copy; {{ date('Y') }} SIMAK. All rights reserved.
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
