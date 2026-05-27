@extends('layouts.app')

@section('content')

<div class="card card-dashboard">
    <div class="card-body">
        <h3 class="mb-4">Detail Barang</h3>
        <table class="table">
            <tr>
                <th>Kode Barang</th>
                <td>{{ $barang->kode_barang }}</td>
            </tr>
            <tr>
                <th>Nama Barang</th>
                <td>{{ $barang->nama_barang }}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $barang->kategori }}</td>
            </tr>
            <tr>
                <th>Jumlah</th>
                <td>{{ $barang->jumlah }}</td>
            </tr>
            <tr>
                <th>Deskripsi</th>
                <td>{{ $barang->deskripsi }}</td>
            </tr>
            <tr>
                <th>Status Barang</th>
                <td>
                    @if($barang->status == 'Barang Diproses')
                        <span class="badge bg-warning text-dark">
                            Barang Diproses
                        </span>
                    @elseif($barang->status == 'Barang Dikirim')
                        <span class="badge bg-primary">
                            Barang Dikirim
                        </span>
                    @elseif($barang->status == 'Barang Sampai Gudang')
                        <span class="badge bg-info text-dark">
                            Barang Sampai Gudang
                        </span>
                    @elseif($barang->status == 'Barang Diterima')
                        <span class="badge bg-success">
                            Barang Diterima
                        </span>
                    @endif
                </td>
            </tr>
        </table>

        <hr>
        <h3 class="mb-4">Timeline Distribusi</h3>
        <div class="timeline">
            @foreach($barang->trackings as $tracking)
            <div class="card mb-3">
                <div class="card-body">
                    @if($tracking->status == 'Barang Diproses')
                        <span class="badge bg-warning text-dark mb-2">
                            Barang Diproses
                        </span>
                    @elseif($tracking->status == 'Barang Dikirim')
                        <span class="badge bg-primary mb-2">
                            Barang Dikirim
                        </span>
                    @elseif($tracking->status == 'Barang Sampai Gudang')
                        <span class="badge bg-info text-dark mb-2">
                            Barang Sampai Gudang
                        </span>
                    @elseif($tracking->status == 'Barang Diterima')
                        <span class="badge bg-success mb-2">
                            Barang Diterima
                        </span>
                    @endif
                    <p class="mb-1">Lokasi:{{ $tracking->lokasi }}</p>
                    <small class="text-muted">{{ $tracking->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection