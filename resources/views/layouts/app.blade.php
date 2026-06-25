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

        .kpi-card{
            border:none;
            border-radius:18px;
            overflow:hidden;
            transition:.3s;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
        }

        .kpi-card:hover{
            transform:translateY(-8px);
            box-shadow:0 10px 25px rgba(13,110,253,.15);
        }

        .kpi-icon{
            width:60px;
            height:60px;
            border-radius:15px;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:26px;
            margin-bottom:20px;
        }

        .kpi-number{
            font-size:34px;
            font-weight:bold;
        }

        .kpi-title{
            font-size:16px;
            font-weight:700;
            color:inherit;
        }

        .kpi-number{
            font-size:40px;
            font-weight:700;
            line-height:1.1;
        }

        .kpi-footer{
            margin-top:18px;
            font-size:14px;
            color:inherit;
            font-weight:500;
        }

        .table-hover tbody tr{
            transition:.2s;
        }

        .table-hover tbody tr:hover{
            transform:scale(1.01);
            box-shadow:0 3px 12px rgba(0,0,0,.08);
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
    <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow-sm mb-4 px-4">
        <div class="container-fluid">
            <div>
                <h4 class="mb-0 fw-bold">
                    @yield('title', 'Dashboard')
                </h4>
                <small class="text-muted">
                    Sistem Monitoring Distribusi Barang
                </small>
            </div>
            <div class="d-flex align-items-center">
                <div class="text-end me-3">
                    <div class="fw-semibold">
                        {{ Auth::user()->name }}
                    </div>
                    <small class="text-muted">
                        {{ ucfirst(Auth::user()->role) }}
                    </small>
                </div>
                <div class="dropdown">
                    <button
                        class="btn btn-light rounded-circle border"
                        data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle fs-4"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item"
                                href="{{ route('profile.edit') }}">
                                <i class="bi bi-person"></i>
                                Profile
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form
                                method="POST"
                                action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
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