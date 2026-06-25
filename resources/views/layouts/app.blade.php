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
        body{
            background:#f4f6f9;
        }

        .sidebar{
            width:260px;
            min-height:100vh;
            background:linear-gradient(
                180deg,
                #0d6efd 0%,
                #0a58ca 100%
            );
            box-shadow:4px 0 15px rgba(0,0,0,.08);
        }

        .sidebar .logo{
            padding:30px 20px;
            text-align:center;
            border-bottom:1px solid rgba(255,255,255,.15);
        }

        .sidebar .logo h4{
            color:white;
            margin:0;
            font-weight:700;
        }

        .sidebar a{
            display:flex;
            align-items:center;
            gap:12px;
            margin:8px 12px;
            padding:14px 18px;
            border-radius:12px;
            color:white;
            text-decoration:none;
            transition:.25s;
            font-weight:500;
        }

        .sidebar a i{
            font-size:20px;
        }

        .sidebar a:hover{
            background:rgba(255,255,255,.15);
            transform:translateX(5px);
        }

        .sidebar a.active{
            background:white;
            color:#0d6efd;
            font-weight:700;
            box-shadow:0 3px 10px rgba(0,0,0,.15);
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
        <div class="logo">
            <i class="bi bi-box-seam-fill text-white"
            style="font-size:50px;"></i>
            <h4 class="mt-3">
                LOGISTIK
            </h4>
            <small class="text-white-50">
                Monitoring Distribusi
            </small>
        </div>

        {{-- MENU ADMIN --}}
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="{{ route('barang.index') }}"
            class="{{ request()->is('barang*') ? 'active' : '' }}">
                <i class="bi bi-box"></i>
                Data Barang
            </a>

            <a href="{{ route('laporan.index') }}"
            class="{{ request()->is('laporan*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-pdf"></i>
                Laporan Distribusi
            </a>

            <a href="/hitung-saw"
            class="{{ request()->is('hitung-saw') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i>
                Perhitungan SAW
            </a>

            <a href="/barang/export/pdf-qr">
                <i class="bi bi-qr-code"></i>
                Export QR
            </a>

            <a href="{{ route('kurir.index') }}"
            class="{{ request()->is('kurir*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                Kelola Kurir
            </a>
        @endif

        {{-- MENU KURIR --}}
        @if(Auth::user()->role == 'kurir')
            <a href="/scan-qr"
            class="{{ request()->is('scan-qr') ? 'active' : '' }}">
            <i class="bi bi-qr-code-scan"></i>
                Scan QR
            </a>

            <a href="/riwayat-pengiriman"
            class="{{ request()->is('riwayat-pengiriman') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                Riwayat Pengiriman
            </a>
        @endif

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

@stack('scripts')

</body>
</html>