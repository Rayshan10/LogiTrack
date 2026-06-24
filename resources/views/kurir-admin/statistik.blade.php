@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0 mb-4">

        <div class="card-body">

            <h2 class="mb-3">
                Statistik Kurir
            </h2>

            <h4>
                {{ $kurir->name }}
            </h4>

            <p class="text-muted">
                {{ $kurir->email }}
            </p>

        </div>

    </div>

    <div class="row mb-4">

        <div class="col-md-3">

            <div class="card bg-primary text-white shadow border-0">

                <div class="card-body text-center">

                    <h6>Total Aktivitas</h6>

                    <h2>
                        {{ $totalAktivitas }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-warning text-dark shadow border-0">

                <div class="card-body text-center">

                    <h6>Barang Dikirim</h6>

                    <h2>
                        {{ $barangDikirim }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-success text-white shadow border-0">

                <div class="card-body text-center">

                    <h6>Barang Diterima</h6>

                    <h2>
                        {{ $barangDiterima }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-dark text-white shadow border-0">

                <div class="card-body text-center">

                    <h6>Tingkat Keberhasilan</h6>

                    <h2>
                        {{ $persentaseKeberhasilan }}%
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow border-0 mb-4">

        <div class="card-header bg-success text-white">

            Grafik Aktivitas Kurir

        </div>

        <div class="card-body">

            <canvas id="grafikKurir"></canvas>

        </div>

    </div>

    <div class="card shadow border-0">

        <div class="card-header bg-dark text-white">

            Riwayat Aktivitas Kurir

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Lokasi</th>
                        <th>Waktu</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($riwayat as $item)

                    <tr>

                        <td>
                            {{ $item->barang->kode_barang ?? '-' }}
                        </td>

                        <td>
                            {{ $item->barang->nama_barang ?? '-' }}
                        </td>

                        <td>

                            @if($item->status == 'Barang Dikirim')

                                <span class="badge bg-primary">
                                    Barang Dikirim
                                </span>

                            @elseif($item->status == 'Barang Diterima')

                                <span class="badge bg-success">
                                    Barang Diterima
                                </span>

                            @else

                                <span class="badge bg-warning text-dark">
                                    {{ $item->status }}
                                </span>

                            @endif

                        </td>

                        <td>
                            {{ $item->lokasi }}
                        </td>

                        <td>
                            {{ $item->created_at->format('d M Y H:i') }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            Belum ada aktivitas

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function(){

    const ctx = document.getElementById('grafikKurir');

    if(!ctx) return;

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: [

                @foreach($aktivitasBulanan as $item)
                    'Bulan {{ $item->bulan }}',
                @endforeach

            ],

            datasets: [{

                label: 'Jumlah Aktivitas',

                data: [

                    @foreach($aktivitasBulanan as $item)
                        {{ $item->total }},
                    @endforeach

                ],

                backgroundColor: '#0d6efd',

                borderColor: '#0d6efd',

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            scales: {

                y: {

                    beginAtZero: true

                }

            }

        }

    });

});

</script>

@endpush

@endsection