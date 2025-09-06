<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') - {{ config('app.name', 'Yayasan Faisal') }}</title>
    <link rel="icon" href="{{ asset('download.png') }}" type="image/png">
    <!-- SB Admin 2 CSS -->
    <link href="{{ asset('sb-admin-2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sb-admin-2/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .action-card {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            font-size: 1.2rem;
            border-radius: 8px;
        }

        .edit-card {
            background-color: #fff3cd; /* kuning lembut */
            color: #856404;
        }

        .edit-card:hover {
            background-color: #ffe8a1;
            transform: scale(1.1);
        }

        .receipt-card {
            background-color: #d1ecf1; /* biru muda */
            color: #0c5460;
        }

        .receipt-card:hover {
            background-color: #a7dee7;
            transform: scale(1.1);
        }

        .delete-card {
            background-color: #f8d7da; /* merah lembut */
            color: #721c24;
        }

        .delete-card:hover {
            background-color: #f5a6ab;
            transform: scale(1.1);
        }
    </style>

</head>

<body id="page-top">
    <div id="wrapper">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                {{-- Topbar --}}
                @include('partials.topbar')

                {{-- Main Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>

            {{-- Footer --}}
            @include('partials.footer')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('sb-admin-2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('sb-admin-2/js/sb-admin-2.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
