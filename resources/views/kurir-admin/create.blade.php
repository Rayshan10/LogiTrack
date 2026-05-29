@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3>Tambah Kurir</h3>

        <form action="{{ route('kurir.store') }}"
              method="POST">

            @csrf

            <div class="mb-3">

                <label>Nama</label>

                <input type="text"
                       name="name"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Password</label>

                <input type="password"
                       name="password"
                       class="form-control">

            </div>

            <button class="btn btn-primary">

                Simpan

            </button>

        </form>

    </div>

</div>

@endsection