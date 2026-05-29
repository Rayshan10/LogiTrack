@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3 class="mb-4">

            Riwayat Pengiriman Saya

        </h3>

        <div class="alert alert-info">

    <strong>Kurir:</strong>

    {{ auth()->user()->name }}

</div>

        <div class="row mb-4">

    <div class="col-md-4">

        <div class="card shadow border-0">

            <div class="card-body text-center">

                <h6>Total Aktivitas</h6>

                <h2 class="text-primary">
                    {{ $totalPengiriman }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow border-0">

            <div class="card-body text-center">

                <h6>Barang Dikirim</h6>

                <h2 class="text-warning">
                    {{ $barangDikirim }}
                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow border-0">

            <div class="card-body text-center">

                <h6>Barang Diterima</h6>

                <h2 class="text-success">
                    {{ $barangDiterima }}
                </h2>

            </div>

        </div>

    </div>

</div>

        <table class="table table-bordered table-striped shadow-sm">

            <thead class="table-primary">

                <tr>

                    <th>Kode Barang</th>

                    <th>Nama Barang</th>

                    <th>Status</th>

                    <th>Lokasi</th>

                    <th>Waktu</th>

                </tr>

            </thead>

            <tbody>

                @forelse($riwayat as $tracking)

                <tr>

                    <td>
                        {{ $tracking->barang->kode_barang }}
                    </td>

                    <td>
                        {{ $tracking->barang->nama_barang }}
                    </td>

                    <td>

                        @if($tracking->status == 'Barang Dikirim')

                            <span class="badge bg-primary">
                                Barang Dikirim
                            </span>

                        @elseif($tracking->status == 'Barang Diterima')

                            <span class="badge bg-success">
                                Barang Diterima
                            </span>

                        @else

                            <span class="badge bg-warning text-dark">
                                {{ $tracking->status }}
                            </span>

                        @endif

                    </td>

                    <td>
                        {{ $tracking->lokasi }}
                    </td>

                    <td>
                        {{ $tracking->created_at
                            ->format('d M Y H:i') }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="text-center">

                        Belum ada riwayat pengiriman

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection