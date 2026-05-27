@php
    use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Distribusi Barang</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f5f7fb;
        }

        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #0d6efd;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 15px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
        }

        .content {
            width: 100%;
            padding: 20px;
        }

        .card-dashboard {
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="d-flex">

    <!-- Sidebar -->
    <div class="sidebar">

        <div class="text-center py-4">
            <h4 class="text-white">
                <i class="bi bi-box-seam"></i>
                LOGISTIK
            </h4>
        </div>

        <a href="/dashboard">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a href="/barang">
            <i class="bi bi-box"></i>
            Data Barang
        </a>

        <a href="#">
            <i class="bi bi-truck"></i>
            Pengiriman
        </a>

        <a href="/scan-qr">
            <i class="bi bi-qr-code-scan"></i>
            Scan QR
        </a>

        <a href="#">
            <i class="bi bi-file-earmark-text"></i>
            Laporan
        </a>

    </div>

    <!-- Content -->
    <div class="content">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom rounded mb-4 px-3">
        <div class="container-fluid">
            <h5 class="mb-0">
                Sistem Monitoring Distribusi Barang
            </h5>

    <div class="d-flex align-items-center gap-2">
        <span>
            Halo, {{ Auth::user()->name }}
        </span>
        <a href="/profile"
            class="btn btn-primary btn-sm">
            Profile
        </a>
        <form method="POST"
            action="{{ route('logout') }}">
            @csrf
                <button type="submit"
                    class="btn btn-danger btn-sm">
                    Logout
                </button>
        </form>

</div>

        </nav>

        <!-- Main Content -->
        @yield('content')

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>