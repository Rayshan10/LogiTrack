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
        </table>

        <hr>
        <h3 class="mb-3">Update Status Distribusi</h3>
        <form action="/barang/{{ $barang->id }}/update-status"method="POST">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <select name="status"class="form-control"required>
                        <option value="">Pilih Status</option>
                        <option value="Barang Diproses">Barang Diproses</option>
                        <option value="Barang Dikirim">Barang Dikirim</option>
                        <option value="Barang Sampai Gudang">Barang Sampai Gudang</option>
                        <option value="Barang Diterima">Barang Diterima</option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <input type="text"
                        name="lokasi"
                        class="form-control"
                        placeholder="Lokasi distribusi"
                        required>
                </div>
                
                <div class="col-md-4">
                    <button type="submit"
                        class="btn btn-primary">
                        Update Status
                    </button>
                </div>
            </div>
        </form>

        <hr>
        <h3 class="mb-4">Timeline Distribusi</h3>
        <div class="timeline">
            @foreach($barang->trackings as $tracking)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $tracking->status }}</h5>
                    <p class="mb-1">Lokasi:{{ $tracking->lokasi }}</p>
                    <small class="text-muted">{{ $tracking->created_at->format('d M Y H:i') }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection