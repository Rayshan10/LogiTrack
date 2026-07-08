@extends('layouts.app')

@section('title', 'Perhitungan SAW')

@section('content')

<div class="container-fluid">
    <div class="card shadow border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Perhitungan SAW</h2>

            <div class="d-flex gap-2">
                <a href="{{ url('/hitung-saw') }}"
                    class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise"></i>
                    Hitung Ulang SAW
                </a>
                <a href="/export-saw-pdf"
                    class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Export PDF
                </a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-danger text-white shadow border-0">
                        <div class="card-body text-center">
                            <h1>{{ $sangatPrioritas }}</h1>
                            <h5>Sangat Prioritas</h5>
                            <small>
                                {{ $persenSangat }} %
                                dari seluruh barang
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning shadow border-0">
                        <div class="card-body text-center">
                            <h1>{{ $prioritas }}</h1>
                            <h5>Prioritas</h5>
                            <small>
                                {{ $persenPrioritas }} %
                                dari seluruh barang
                            </small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-success text-white shadow border-0">
                        <div class="card-body text-center">
                            <h1>{{ $normal }}</h1>
                            <h5>Normal</h5>
                            <small>
                                {{ $persenNormal }} %
                                dari seluruh barang
                            </small>
                        </div>
                    </div>
                </div>
            </div>

    @if($rankingSAW->count())

    <div class="alert alert-danger">
        <h5>
            🏆 Barang Prioritas Tertinggi
        </h5>
        <strong>
            {{ $rankingSAW->first()->kode_barang }}
        </strong>
        -
        {{ $rankingSAW->first()->nama_barang }}
        <br>
        Nilai SAW :
        <strong>
            {{ $rankingSAW->first()->nilai_saw }}
        </strong>
    </div>

    @endif
<div class="card shadow border-0">
        <div class="card-header bg-dark text-white">
            Ranking Prioritas Distribusi
        </div>
        <div class="card-body">
            <div class="table-responsive" style="max-height:400px; overflow-y:auto;">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Nilai SAW</th>
                            <th>Prioritas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rankingSAW as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $item->kode_barang }}
                            </td>
                            <td>
                                {{ $item->nama_barang }}
                            </td>
                            <td>
                                {{ $item->nilai_saw }}
                            </td>
                            <td>
                                @if($item->nilai_saw >= 0.8)
                                    <span class="badge bg-danger">
                                        Sangat Prioritas
                                    </span>
                                @elseif($item->nilai_saw >= 0.6)
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
            </div>            
        </div>
    </div>
</div>
<br>
    <div class="row">
        <!-- Grafik Ranking -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        Grafik Ranking SAW
                    </h5>
                </div>
                <div class="card-body">
                    <div style="height:380px">
                        <canvas id="rankingChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Doughnut -->
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        Distribusi Prioritas Barang
                    </h5>
                </div>
                <div class="card-body">
                    <div style="height:380px">
                        <canvas id="grafikPrioritas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row mb-4">
        <!-- Bobot -->
        <div class="col-lg-7">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-sliders"></i>
                        Bobot Kriteria SAW
                    </h5>
                </div>

                <div class="card-body">
                    <table class="table table-borderless align-middle mb-0">
                        <tr>
                            <td width="45%">
                                <span class="badge bg-danger">
                                    Urgensi
                                </span>
                            </td>
                            <td>
                                <strong>40%</strong>
                            </td>
                            <td width="45%">
                                <div class="progress">
                                    <div
                                        class="progress-bar bg-danger"
                                        style="width:40%">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    Lama Penyimpanan
                                </span>
                            </td>
                            <td>
                                <strong>35%</strong>
                            </td>
                            <td>
                                <div class="progress">
                                    <div
                                        class="progress-bar bg-warning"
                                        style="width:35%">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="badge bg-success">
                                    Keterlambatan
                                </span>
                            </td>
                            <td>
                                <strong>25%</strong>
                            </td>
                            <td>
                                <div class="progress">
                                    <div
                                        class="progress-bar bg-success"
                                        style="width:25%">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <hr>
                    <div class="text-end">
                        <span class="badge bg-primary fs-6">
                            Total Bobot = 100%
                        </span>
                    </div>
                    
                    <div class="card shadow border-0 mt-4">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-bar-chart-fill"></i>
                                Interpretasi Hasil Perhitungan SAW
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Total Barang</td>
                                            <td>
                                                <strong>
                                                    {{ $rankingSAW->count() }}
                                                </strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Sangat Prioritas</td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    {{ $sangatPrioritas }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Prioritas</td>
                                            <td>
                                                <span class="badge bg-warning text-dark">
                                                    {{ $prioritas }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Normal</td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $normal }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <div class="alert alert-info mb-0">
                                        <h6>
                                            <i class="bi bi-lightbulb-fill"></i>
                                            Kesimpulan
                                        </h6>
                                        <p class="mb-0">
                                            {{ $kesimpulan }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mt-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-info-circle-fill"></i>
                                Kategori Prioritas Distribusi
                            </h5>
                        </div>

                        <div class="card-body">
                            <div class="mb-4">
                                <span class="badge bg-danger fs-6">
                                    Sangat Prioritas
                                </span>
                                <small class="text-muted ms-2">
                                    Nilai SAW ≥ 0.80
                                </small>
                                <p class="mt-2 mb-0">
                                    Barang memiliki tingkat urgensi yang tinggi
                                    sehingga harus menjadi prioritas utama dalam
                                    proses distribusi.
                                </p>
                            </div>
                            <hr>
                            <div class="mb-4">
                                <span class="badge bg-warning text-dark fs-6">
                                    Prioritas
                                </span>
                                <small class="text-muted ms-2">
                                    Nilai SAW 0.60 – 0.79
                                </small>
                                <p class="mt-2 mb-0">
                                    Barang direkomendasikan untuk didistribusikan
                                    setelah seluruh kategori Sangat Prioritas selesai.
                                </p>
                            </div>
                            <hr>
                            <div>
                                <span class="badge bg-success fs-6">
                                    Normal
                                </span>
                                <small class="text-muted ms-2">
                                    Nilai SAW &lt; 0.60
                                </small>
                                <p class="mt-2 mb-0">
                                    Barang masih berada pada kondisi distribusi
                                    normal sehingga dapat dikirim sesuai jadwal reguler.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rumus -->
        <div class="col-lg-5">
            <div class="card shadow border-0 h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calculator"></i>
                        Rumus SAW
                    </h5>
                </div>

                <div class="card-body">
                    <h2 class="text-center text-primary fw-bold">
                        V<sub>i</sub> = Σ (W<sub>j</sub> × R<sub>ij</sub>)
                    </h2>
                    <hr>
                    <table class="table table-sm align-middle">
                        <tr>
                            <td width="20%">
                                <strong>V</strong>
                            </td>
                            <td>
                                Nilai Preferensi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>W</strong>
                            </td>
                            <td>
                                Bobot Kriteria
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>R</strong>
                            </td>
                            <td>
                                Nilai Normalisasi
                            </td>
                        </tr>
                    </table>

                    <div class="card border-primary mt-3">
                        <div class="card-header bg-primary text-white py-2">
                            <strong>
                                <i class="bi bi-diagram-3"></i>
                                Jenis Kriteria
                            </strong>
                        </div>

                        <div class="card-body p-2">
                            <table class="table table-sm mb-0">
                                <tr>
                                    <td>
                                        <span class="badge bg-danger">
                                            Urgensi
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            Benefit
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge bg-warning text-dark">
                                            Lama Penyimpanan
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">
                                            Cost
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="badge bg-success">
                                            Keterlambatan
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">
                                            Cost
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0">
                        <h6 class="fw-bold">
                            <i class="bi bi-calculator"></i>
                            Rumus Normalisasi
                        </h6>
                        <hr class="my-2">
                        <strong>Benefit</strong>
                        <div class="text-center fs-5 text-primary">
                            R<sub>ij</sub> =
                            X<sub>ij</sub> /
                            Max(X<sub>ij</sub>)
                        </div>
                        <br>
                        <strong>Cost</strong>
                        <div class="text-center fs-5 text-danger">
                            R<sub>ij</sub> =
                            Min(X<sub>ij</sub>) /
                            X<sub>ij</sub>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Grafik Ranking SAW
    |--------------------------------------------------------------------------
    */

    const rankingCtx = document.getElementById('rankingChart');

    if (rankingCtx) {

        new Chart(rankingCtx, {

            type: 'bar',

            data: {

                labels: [

                    @foreach($rankingSAW as $item)
                        '{{ $item->kode_barang }}',
                    @endforeach

                ],

                datasets: [{

                    label: 'Nilai SAW',

                    data: [

                        @foreach($rankingSAW as $item)
                            {{ $item->nilai_saw }},
                        @endforeach

                    ],

                    backgroundColor: '#0d6efd',

                    borderRadius: 5

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

                        beginAtZero: true,

                        max: 1

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Doughnut Distribusi Prioritas
    |--------------------------------------------------------------------------
    */

    const prioritasCtx = document.getElementById('grafikPrioritas');

    if (prioritasCtx) {

        new Chart(prioritasCtx, {

            type: 'doughnut',

            data: {

                labels: [

                    'Sangat Prioritas',

                    'Prioritas',

                    'Normal'

                ],

                datasets: [{

                    data: [

                        {{ $sangatPrioritas }},

                        {{ $prioritas }},

                        {{ $normal }}

                    ],

                    backgroundColor: [

                        '#dc3545',

                        '#ffc107',

                        '#198754'

                    ],

                    borderWidth: 2

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

});

</script>

@endpush
@endsection