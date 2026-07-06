@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <!-- KPI Dashboard -->
    <div class="row g-4 mb-4">

        <!-- Total Kurir -->
        <div class="col-xl col-lg-4 col-md-6">
            <div class="card kpi-card bg-dark text-white h-100">
                <div class="card-body">
                    <div class="kpi-icon bg-secondary">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div class="kpi-title">
                        Total Kurir
                    </div>
                    <div class="kpi-number">
                        {{ $totalKurir }}
                    </div>
                    <div class="kpi-footer">
                        <i class="bi bi-people"></i>
                        Kurir aktif
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Barang -->
        <div class="col-xl col-lg-4 col-md-6">
            <div class="card kpi-card h-100">
                <div class="card-body">
                    <div class="kpi-icon bg-primary text-white">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div class="kpi-title text-muted">
                        Total Barang
                    </div>
                    <div class="kpi-number">
                        {{ $totalBarang }}
                    </div>
                    <div class="kpi-footer">
                        <i class="bi bi-box"></i>
                        Barang terdaftar
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Diproses -->
        <div class="col-xl col-lg-4 col-md-6">
            <div class="card kpi-card bg-warning text-dark h-100">
                <div class="card-body">
                    <div class="kpi-icon bg-white text-warning">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="kpi-title">
                        Barang Diproses
                    </div>
                    <div class="kpi-number">
                        {{ $barangDiproses }}
                    </div>
                    <div class="kpi-footer">
                        <i class="bi bi-arrow-repeat"></i>
                        Sedang diproses
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Dikirim -->
        <div class="col-xl col-lg-4 col-md-6">
            <div class="card kpi-card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="kpi-icon bg-white text-primary">
                        <i class="bi bi-truck"></i>
                    </div>
                    <div class="kpi-title">
                        Barang Dikirim
                    </div>
                    <div class="kpi-number">
                        {{ $barangDikirim }}
                    </div>
                    <div class="kpi-footer">
                        <i class="bi bi-send"></i>
                        Dalam perjalanan
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Diterima -->
        <div class="col-xl col-lg-4 col-md-6">
            <div class="card kpi-card bg-success text-white h-100">
                <div class="card-body">
                    <div class="kpi-icon bg-white text-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="kpi-title">
                        Barang Diterima
                    </div>
                    <div class="kpi-number">
                        {{ $barangDiterima }}
                    </div>
                    <div class="kpi-footer">
                        <i class="bi bi-check2-all"></i>
                        Pengiriman selesai
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->

    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <form method="GET"
                action="/dashboard">
                <div class="row">
                    <!-- Cari kode barang -->
                    <div class="col-md-3">
                        <label>Kode Barang</label>
                        <input type="text"
                            name="kode_barang"
                            class="form-control"
                            placeholder="Cari kode barang"
                            value="{{ request('kode_barang') }}">
                    </div>

                    <!-- Status -->
                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua</option>
                            <option value="Barang Diproses">Barang Diproses</option>
                            <option value="Barang Dikirim">Barang Dikirim</option>
                            <option value="Barang Diterima">Barang Diterima</option>
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="col-md-2">
                        <label>Tanggal</label>
                        <input type="date"
                                name="tanggal"
                                class="form-control"
                                value="{{ request('tanggal') }}">
                    </div>

                    <!-- Prioritas -->
                    <div class="col-md-3">
                        <label>Prioritas SAW</label>
                        <select name="prioritas"class="form-control">
                            <option value="">Semua</option>
                            <option value="sangat_prioritas">Sangat Prioritas</option>
                            <option value="prioritas">Prioritas</option>
                            <option value="normal">Normal</option>
                        </select>
                    </div>

                    <!-- Tombol -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit"class="btn btn-primary w-100">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Aktivitas Distribusi -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="mb-1">
                        Aktivitas Distribusi Terbaru
                    </h3>
                    <small class="text-muted">
                        Monitoring aktivitas distribusi barang secara real-time
                    </small>
                </div>
                <span class="badge bg-primary fs-6">
                    {{ $trackingTerbaru->count() }}
                    Aktivitas
                </span>
            </div>

            @php
                $barangDiterimaTerbaru = $trackingTerbaru
                    ->where('status', 'Barang Diterima')
                    ->first();
            @endphp

            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>User</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Lokasi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($trackingTerbaru as $tracking)
                    <tr>
                        <td>
                            <i class="bi bi-person-circle text-primary"></i>
                            <strong>
                                {{ $tracking->user->name }}
                            </strong>
                        </td>
                        <td>
                            {{ $tracking->barang->kode_barang }}
                        </td>
                        <td>
                            {{ $tracking->barang->nama_barang }}
                        </td>
                        <td>
                            @if($tracking->status == 'Barang Diproses')
                                <span class="badge bg-warning text-dark">
                                    Barang Diproses
                                </span>
                            @elseif($tracking->status == 'Barang Dikirim')
                                <span class="badge bg-primary">
                                    Barang Dikirim
                                </span>
                            @elseif($tracking->status == 'Barang Sampai Gudang')
                                <span class="badge bg-info text-dark">
                                    Barang Sampai Gudang
                                </span>
                            @elseif($tracking->status == 'Barang Diterima')
                                <span class="badge bg-success">
                                    Barang Diterima
                                </span>
                            @endif
                        </td>

                        <td>
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            {{ $tracking->lokasi }}
                        </td>

                        <td>
                            <i class="bi bi-clock-history text-secondary"></i>
                            {{ $tracking->created_at->format('d M Y') }}
                            <br>
                            <small class="text-muted">
                                {{ $tracking->created_at->format('H:i') }}
                            </small>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Grafik Status -->
        <div class="col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white">
                    Grafik Status Distribusi
                </div>
                <div class="card-body">
                    <div style="height:320px">
                        <canvas id="grafikStatus"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Kategori -->
        <div class="col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-success text-white">
                    Grafik Kategori Barang
                </div>
                <div class="card-body">
                    <div style="height:320px">
                        <canvas id="grafikKategori"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-danger text-white">
            🏆 Barang Prioritas Tertinggi
        </div>
        <div class="card-body">
            @if($barangPrioritas)
                <h4 class="fw-bold">
                    {{ $barangPrioritas->nama_barang }}
                </h4>
                <hr>
                <div class="row">
                    <div class="col-md-3">
                        <strong>Kode</strong><br>
                        {{ $barangPrioritas->kode_barang }}
                    </div>
                    <div class="col-md-3">
                        <strong>Kategori</strong><br>
                        {{ $barangPrioritas->kategori }}
                    </div>
                    <div class="col-md-3">
                        <strong>Status</strong><br>
                        {{ $barangPrioritas->status }}
                    </div>
                    <div class="col-md-3">
                        <strong>Nilai SAW</strong><br>
                        <span class="badge bg-success fs-6">
                            {{ number_format($barangPrioritas->nilai_saw,3) }}
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card shadow border-0 mb-4">
        <div class="card-header bg-dark text-white">
            📊 Top 10 Prioritas Distribusi
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Nilai SAW</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($topPrioritas as $barang)
                    <tr>
                        <td>
                            <span class="badge bg-primary">
                                {{ $loop->iteration }}
                            </span>
                        </td>
                        <td>
                            {{ $barang->kode_barang }}
                        </td>
                        <td>
                            {{ $barang->nama_barang }}
                        </td>
                        <td>
                            {{ $barang->status }}
                        </td>
                        <td>
                            <strong>
                                {{ number_format($barang->nilai_saw,3) }}
                            </strong>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusCtx = document.getElementById('grafikStatus');
            if (statusCtx) {
                new Chart(statusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: [
                            'Diproses',
                            'Dikirim',
                            'Diterima'
                        ],
                        datasets: [{
                            data: [
                                {{ $barangDiproses }},
                                {{ $barangDikirim }},
                                {{ $barangDiterima }}
                            ],

                            backgroundColor: [
                                '#ffc107',
                                '#0d6efd',
                                '#198754'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }

            const kategoriCtx = document.getElementById('grafikKategori');

            if (kategoriCtx) {
                new Chart(kategoriCtx, {
                    type: 'bar',
                    data: {
                        labels: [
                            @foreach($grafikKategori as $item)
                                '{{ $item->kategori }}',
                            @endforeach
                        ],

                        datasets: [{
                            label: 'Jumlah Barang',
                            data: [
                                @foreach($grafikKategori as $item)
                                    {{ $item->total }},
                                @endforeach
                            ],
                            backgroundColor: '#198754'
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        });
    </script>

@endpush

@endsection