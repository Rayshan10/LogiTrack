@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Dashboard Monitoring Logistik
        </h2>

    </div>

    <!-- KPI Dashboard -->

    <div class="row mb-4">

        <div class="col-lg col-md-6 mb-3">

            <div class="card shadow border-0 bg-dark text-white h-100">

                <div class="card-body text-center">

                    <i class="bi bi-truck fs-1"></i>

                    <h6 class="mt-2">
                        Total Kurir
                    </h6>

                    <h2>
                        {{ $totalKurir }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-3">

            <div class="card shadow border-0 h-100">

                <div class="card-body text-center">

                    <i class="bi bi-box-seam fs-1 text-primary"></i>

                    <h6 class="mt-2 text-muted">
                        Total Barang
                    </h6>

                    <h2>
                        {{ $totalBarang }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-3">

            <div class="card shadow border-0 bg-warning text-white h-100">

                <div class="card-body text-center">

                    <i class="bi bi-hourglass-split fs-1"></i>

                    <h6 class="mt-2">
                        Barang Diproses
                    </h6>

                    <h2>
                        {{ $barangDiproses }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-3">

            <div class="card shadow border-0 bg-primary text-white h-100">

                <div class="card-body text-center">

                    <i class="bi bi-send fs-1"></i>

                    <h6 class="mt-2">
                        Barang Dikirim
                    </h6>

                    <h2>
                        {{ $barangDikirim }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6 mb-3">

            <div class="card shadow border-0 bg-success text-white h-100">

                <div class="card-body text-center">

                    <i class="bi bi-check-circle fs-1"></i>

                    <h6 class="mt-2">
                        Barang Diterima
                    </h6>

                    <h2>
                        {{ $barangDiterima }}
                    </h2>

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