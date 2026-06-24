@extends('layouts.app')

<style>

.timeline {
    position: relative;
    margin-left: 25px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 12px;
    top: 0;
    bottom: 0;
    width: 3px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 25px;
    padding-left: 40px;
}

.timeline-dot {
    position: absolute;
    left: -1px;
    top: 5px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #0d6efd;
    border: 4px solid white;
    box-shadow: 0 0 0 2px #0d6efd;
}

.timeline-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

</style>

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
        <h3 class="mb-4">
            Riwayat Distribusi Barang
        </h3>
        <div class="timeline">
            @forelse($barang->trackings as $tracking)
            <div class="timeline-item">
                <div class="timeline-dot
                    @if($tracking->status == 'Barang Diproses')
                        bg-warning
                    @elseif($tracking->status == 'Barang Dikirim')
                        bg-primary
                    @elseif($tracking->status == 'Barang Sampai Gudang')
                        bg-info
                    @elseif($tracking->status == 'Barang Diterima')
                        bg-success
                    @endif
                "></div>
                <div class="card timeline-card">
                    <div class="card-body">
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
                        <div class="mt-3">
                            <strong>User:</strong>
                            {{ $tracking->user->name ?? 'Admin' }}
                        </div>
                        <div>
                            <strong>Lokasi:</strong>
                            {{ $tracking->lokasi }}
                        </div>
                        <div>
                            <strong>Waktu:</strong>
                            {{ $tracking->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-warning">
                Belum ada riwayat distribusi.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection