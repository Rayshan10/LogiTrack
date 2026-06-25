@extends('layouts.app')

@section('title', 'Kelola Kurir')

@section('content')

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-primary text-white">

        🏆 Top Kurir

    </div>

    <div class="card-body">

        @foreach($topKurir as $index => $item)

            <div class="d-flex justify-content-between mb-2">

                <div>

                    @if($index == 0)
                        🥇
                    @elseif($index == 1)
                        🥈
                    @elseif($index == 2)
                        🥉
                    @endif

                    {{ $item->name }}

                </div>

                <span class="badge bg-primary">

                    {{ $item->trackings_count }}

                </span>

            </div>

        @endforeach

    </div>

</div>

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-success text-white">
        Grafik Aktivitas Kurir
    </div>

    <div class="card-body">

        @if($topKurir->count() > 0)

            <div style="height: 400px;">
                <canvas id="grafikKurir"></canvas>
            </div>

        @else

            <div class="alert alert-warning mb-0">
                Belum ada data aktivitas kurir
            </div>

        @endif

    </div>

</div>

<div class="card card-dashboard">
    
    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">
            <h3>Data Kurir</h3>
            <a href="{{ route('kurir.create') }}"
                class="btn btn-primary">
                Tambah Kurir
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Total Aktivitas</th>
                    <th>Dikirim</th>
                    <th>Diterima</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($kurir as $k)
                    <tr>
                        <td>{{ $k->name }}</td>
                        <td>{{ $k->email }}</td>
                        <td>
                            <span class="badge bg-primary">
                                {{ $k->total_aktivitas }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-warning text-dark">
                                {{ $k->barang_dikirim }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-success">
                                {{ $k->barang_diterima }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('kurir.statistik', $k->id) }}"
                                class="btn btn-info btn-sm">
                                Statistik
                            </a>
                            <a href="{{ route('kurir.edit',$k->id) }}"
                                class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <form action="{{ route('kurir.destroy',$k->id) }}"
                                method="POST"class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>

window.addEventListener('load', function () {

    const canvas = document.getElementById('grafikKurir');

    if (!canvas) {
        console.log('Canvas grafikKurir tidak ditemukan');
        return;
    }

    const labels = [
        @foreach($topKurir as $item)
            "{{ $item->name }}",
        @endforeach
    ];

    const dataAktivitas = [
        @foreach($topKurir as $item)
            {{ $item->trackings_count }},
        @endforeach
    ];

    console.log(labels);
    console.log(dataAktivitas);

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Aktivitas',
                data: dataAktivitas,
                backgroundColor: [
                    '#0d6efd',
                    '#198754',
                    '#ffc107',
                    '#dc3545',
                    '#6f42c1'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

});

</script>
@endpush
@endsection