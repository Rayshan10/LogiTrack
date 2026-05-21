@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h3>Data Barang</h3>

            <a href="{{ route('barang.create') }}"
                class="btn btn-primary">
                Tambah Barang
            </a>
            <a href="/barang/export/pdf-qr" class="btn btn-danger">
                Export PDF QR
            </a>

        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered table-striped">

            <thead class="table-primary">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>QR Code</th>
                    <th>Status</th>
                    <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @foreach($barang as $b)

                <tr>
                    <td>{{ $b->kode_barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori }}</td>
                    <td>{{ $b->jumlah }}</td>
                    <td>
                        <img src="data:image/svg+xml;base64,{{ $b->qr_code }}"width="180">
                    </td>
                    <td>
                        @if($b->status == 'Barang Diproses')
                        <span class="badge bg-warning">
                            {{ $b->status }}
                        </span>
                        @elseif($b->status == 'Barang Dikirim')
                        <span class="badge bg-primary">
                            {{ $b->status }}
                        </span>
                        @elseif($b->status == 'Barang Sampai Gudang')
                        <span class="badge bg-info">
                            {{ $b->status }}
                        </span>
                        @else
                        <span class="badge bg-success">
                        {{ $b->status }}
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-column gap-2">
                            
                            <button type="button"
                                class="btn btn-success btn-sm w-100"
                                data-bs-toggle="modal"
                                data-bs-target="#qrModal{{ $b->id }}">
                                Preview QR
                            </button>

                            <button class="btn btn-info btn-sm w-100"
                                onclick="copyTrackingLink('{{ url('/barang/'.$b->kode_barang) }}')">
                                <i class="bi bi-clipboard"></i>
                                Copy Link Tracking
                            </button>

                            <a href="{{ route('barang.edit', $b->kode_barang) }}"
                                class="btn btn-warning btn-sm w-100">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>

                            <form action="{{ route('barang.destroy', $b->kode_barang) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Modal Preview QR -->
                <div class="modal fade" id="qrModal{{ $b->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    QR Barang
                                </h5>
                                <button
                                    type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>
                            </div>
                            
                            <div class="modal-body text-center">
                                <h5>
                                    {{ $b->nama_barang }}
                                </h5>
                                <p>
                                    {{ $b->kode_barang }}
                                </p>
                                <img src="data:image/svg+xml;base64,{{ $b->qr_code }}"width="300">
                            </div>

                            <div class="modal-footer">
                                <a href="/barang/{{ $b->id }}/download-qr" class="btn btn-success">
                                    <i class="bi bi-download"></i>
                                    Download QR
                                </a>

                                <a href="/barang/{{ $b->id }}/print-qr" target="_blank" class="btn btn-secondary">
                                    <i class="bi bi-printer"></i>
                                    Cetak QR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function copyTrackingLink(link)
    {
        navigator.clipboard.writeText(link);
        alert('Link tracking berhasil disalin!');
    }
</script>

@endsection