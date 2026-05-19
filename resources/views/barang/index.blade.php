@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">

            <h3>Data Barang</h3>

            <a href="{{ route('barang.create') }}"
                class="btn btn-primary">
                Tambah Barang
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
                    <th width="200">Aksi</th>
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
                        <img src="data:image/svg+xml;base64,{{ $b->qr_code }}"width="80">
                    </td>

                    <td>
                        <a href="{{ route('barang.edit', $b->id) }}"
                            class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <form action="{{ route('barang.destroy', $b->id) }}"
                                method="POST"
                                class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn btn-danger btn-sm">
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

@endsection