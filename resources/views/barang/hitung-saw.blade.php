@extends('layouts.app')

@section('title', 'Perhitungan SAW')

@section('content')

<div class="container-fluid">
    <div class="card shadow border-0 mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="mb-0">
                Perhitungan SAW
            </h2>

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

    <div class="card shadow border-0 mb-4">

        <div class="card-header bg-primary text-white">

            Grafik Ranking SAW

        </div>

        <div class="card-body">

            <canvas id="grafikSAW"></canvas>

        </div>

    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-dark text-white">

            Ranking Prioritas Distribusi

        </div>

        <div class="card-body">

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

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function(){

    const ctx = document.getElementById('grafikSAW');

    if(!ctx) return;

    new Chart(ctx, {

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

                backgroundColor: [

                    '#dc3545', // Ranking 1
                    '#ffc107', // Ranking 2
                    '#198754', // Ranking 3
                    '#0d6efd',
                    '#6f42c1'

                ],

                borderColor: [

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

@endpush
@endsection