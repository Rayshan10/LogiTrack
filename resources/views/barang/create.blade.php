@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3 class="mb-4">Tambah Barang</h3>

        <form action="{{ route('barang.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label>Kode Barang</label>
                <input type="text"
                       name="kode_barang"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <input type="text"
                       name="kategori"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number"
                       name="jumlah"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi"
                          class="form-control"></textarea>
            </div>

            <button type="submit"
                    class="btn btn-primary">
                Simpan
            </button>

        </form>

    </div>

</div>

@endsection