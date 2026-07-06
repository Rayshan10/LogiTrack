@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET">
            <div class="row">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari kode atau nama barang..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary flex-fill">
                            <i class="bi bi-search"></i>
                            Cari
                        </button>
                        <a href="{{ route('barang.index') }}"
                            class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card card-dashboard">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    Data Barang
                </h2>
                <small class="text-muted">
                    Kelola seluruh data barang distribusi
                </small>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('barang.import') }}"
                class="btn btn-primary">
                <i class="bi bi-upload"></i>
                Import
                </a>
                <a href="{{ route('barang.create') }}"
                    class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Barang
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-hover table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th width="60" class="text-center">No</th>
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
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $b->kode_barang }}</td>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori }}</td>
                    <td>{{ $b->jumlah }}</td>
                    <td>
                        <img src="data:image/svg+xml;base64,{{ $b->qr_code }}"width="90">
                    </td>
                    <td>
                        @if($b->status == 'Barang Diproses')
                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                <i class="bi bi-hourglass-split me-1"></i>
                                Barang Diproses
                            </span>
                        @elseif($b->status == 'Barang Dikirim')
                            <span class="badge rounded-pill bg-primary px-3 py-2">
                                <i class="bi bi-truck me-1"></i>
                                Barang Dikirim
                            </span>
                        @elseif($b->status == 'Barang Sampai Gudang')
                            <span class="badge rounded-pill bg-info text-dark px-3 py-2">
                                <i class="bi bi-building me-1"></i>
                                Barang Sampai Gudang
                            </span>
                        @elseif($b->status == 'Barang Diterima')
                            <span class="badge rounded-pill bg-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>
                                Barang Diterima
                            </span>
                        @else
                            <span class="badge rounded-pill bg-secondary px-3 py-2">
                                <i class="bi bi-question-circle me-1"></i>
                                {{ $b->status }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-grid gap-2">
                            <!-- Preview QR -->
                            <button
                                type="button"
                                class="btn btn-success btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#qrModal{{ $b->id }}">
                                <i class="bi bi-qr-code me-1"></i>
                                Preview QR
                            </button>

                            <!-- Detail Barang -->
                            <a href="{{ route('barang.show', $b->kode_barang) }}"
                                class="btn btn-info btn-sm">
                                <i class="bi bi-eye me-1"></i>
                                Detail Barang
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('barang.edit', $b->kode_barang) }}"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square me-1"></i>
                                Edit
                            </a>

                            <!-- Hapus -->
                            <form
                                action="{{ route('barang.destroy', $b->kode_barang) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-danger btn-sm w-100"
                                    onclick="return confirm('Yakin ingin menghapus data barang ini?')">
                                    <i class="bi bi-trash me-1"></i>
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

    Swal.fire({
        title:'Hapus Barang?',
        text:'Data yang dihapus tidak dapat dikembalikan.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#dc3545',
        cancelButtonColor:'#6c757d',
        confirmButtonText:'Ya, Hapus'
    });
</script>

@endsection