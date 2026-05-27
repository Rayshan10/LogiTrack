@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            Dashboard Monitoring Logistik
        </h2>

        <a href="/hitung-saw" class="btn btn-success">
            Hitung Prioritas Distribusi (SAW)
        </a>

    </div>

    <!-- Statistik -->
    <div class="row">

        <!-- Total Barang -->
        <div class="col-md-3 mb-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h6 class="text-muted">
                        Total Barang
                    </h6>

                    <h2>
                        {{ $totalBarang }}
                    </h2>

                </div>

            </div>

        </div>

        <!-- Barang Diproses -->
        <div class="col-md-3 mb-4">

            <div class="card shadow border-0 bg-warning text-white">

                <div class="card-body">

                    <h6>
                        Barang Diproses
                    </h6>

                    <h2>
                        {{ $barangDiproses }}
                    </h2>

                </div>

            </div>

        </div>

        <!-- Barang Dikirim -->
        <div class="col-md-3 mb-4">

            <div class="card shadow border-0 bg-primary text-white">

                <div class="card-body">

                    <h6>
                        Barang Dikirim
                    </h6>

                    <h2>
                        {{ $barangDikirim }}
                    </h2>

                </div>

            </div>

        </div>

        <!-- Barang Diterima -->
        <div class="col-md-3 mb-4">

            <div class="card shadow border-0 bg-success text-white">

                <div class="card-body">

                    <h6>
                        Barang Diterima
                    </h6>

                    <h2>
                        {{ $barangDiterima }}
                    </h2>

                </div>

            </div>

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

    <!-- SAW Section -->
    <div class="card shadow border-0">

        <div class="card-body">

            <h4 class="mb-4">

                Ranking Prioritas Distribusi
                (Metode SAW)

            </h4>

            <!-- Barang Prioritas -->
            @php
                $topPriority = $rankingSAW->first();
            @endphp

            @if($topPriority)

            <div class="alert alert-danger">

                <h5>
                    Barang Prioritas Tertinggi
                </h5>

                <strong>
                    {{ $topPriority->kode_barang }}
                </strong>

                -
                {{ $topPriority->nama_barang }}

                <br>

                Nilai SAW:
                <strong>
                    {{ $topPriority->nilai_saw }}
                </strong>

            </div>

            @endif

            <!-- Grafik SAW -->
            <div class="mb-5">

                <canvas id="sawChart"></canvas>

            </div>

            <!-- Table Ranking -->
            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                    <tr>

                        <th>Ranking</th>

                        <th>Kode Barang</th>

                        <th>Nama Barang</th>

                        <th>Nilai SAW</th>

                        <th>Prioritas</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($rankingSAW as $index => $b)

                    <tr>

                        <td>
                            {{ $index + 1 }}
                        </td>

                        <td>
                            {{ $b->kode_barang }}
                        </td>

                        <td>
                            {{ $b->nama_barang }}
                        </td>

                        <td>

                            <strong>
                                {{ $b->nilai_saw }}
                            </strong>

                        </td>

                        <td>

                            @if($b->nilai_saw >= 0.80)

                                <span class="badge bg-danger">
                                    Sangat Prioritas
                                </span>

                            @elseif($b->nilai_saw >= 0.60)

                                <span class="badge bg-warning text-dark">
                                    Prioritas
                                </span>

                            @else

                                <span class="badge bg-success">
                                    Normal
                                </span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            <a href="/export-saw-pdf" class="btn btn-danger mb-4">
                Export PDF SAW
            </a>

        </div>

    </div>

</div>

<!-- Chart.js -->
<canvas id="sawChart"></canvas>
<script>

document.addEventListener(
    "DOMContentLoaded",
    function ()
{
    const ctx =
        document.getElementById(
            'sawChart'
        );

    if (!ctx)
    {
        console.log(
            'Canvas sawChart tidak ditemukan'
        );

        return;
    }

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [

                @foreach($rankingSAW as $b)

                    '{{ $b->kode_barang }}',

                @endforeach

            ],

            datasets: [{

                label:
                    'Nilai SAW',

                data: [

                    @foreach($rankingSAW as $b)

                        {{ $b->nilai_saw }},

                    @endforeach

                ],

                backgroundColor: [

                    '#dc3545',
                    '#ffc107',
                    '#198754',
                    '#0d6efd',
                    '#6f42c1'

                ],

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: true

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    max: 1

                }

            }

        }

    });

});

</script>

@endsection