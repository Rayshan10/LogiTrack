@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>
            Dashboard Monitoring Logistik
        </h2>
    </div>

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

            <h4 class="mb-4">
                Aktivitas Distribusi Terbaru
            </h4>

            @php
                $barangDiterimaTerbaru = $trackingTerbaru
                    ->where('status', 'Barang Diterima')
                    ->first();
            @endphp

            <table class="table table-bordered table-striped">

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
                            {{ $tracking->user->name }}
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
                            {{ $tracking->lokasi }}
                        </td>

                        <td>
                            {{ $tracking->created_at->format('d M Y H:i') }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-primary text-white">

        Grafik Status Distribusi

    </div>

    <div class="card-body">

        <canvas id="grafikStatus"></canvas>

    </div>

</div>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const ctx =
        document.getElementById('grafikStatus');

    if (!ctx) return;

    new Chart(ctx, {

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
        }

    });

});

</script>

@endpush

@endsection