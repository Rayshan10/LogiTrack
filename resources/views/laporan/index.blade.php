@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3>Laporan Distribusi Barang</h3>

        <hr>

        <form action="{{ route('laporan.export') }}"
              method="POST">

            @csrf

            <div class="row">

                <div class="col-md-5">

                    <label>Tanggal Awal</label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-5">

                    <label>Tanggal Akhir</label>

                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-2">

                    <label>&nbsp;</label>

                    <button
                        class="btn btn-danger w-100">

                        Export PDF

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endsection