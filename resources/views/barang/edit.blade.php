@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3 class="mb-4">Edit Barang</h3>

        <form action="{{ route('barang.update', $barang->kode_barang) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Kode Barang</label>
                <input type="text"
                       name="kode_barang"
                       value="{{ $barang->kode_barang }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text"
                       name="nama_barang"
                       value="{{ $barang->nama_barang }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Kategori</label>
                <input type="text"
                       name="kategori"
                       value="{{ $barang->kategori }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input type="number"
                       name="jumlah"
                       value="{{ $barang->jumlah }}"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi"
                          class="form-control">{{ $barang->deskripsi }}</textarea>
            </div>

            <button type="submit"
                    class="btn btn-primary">
                Update
            </button>

        </form>

    </div>

</div>

@endsection