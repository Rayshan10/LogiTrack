@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3>Edit Kurir</h3>

        <form action="{{ route('kurir.update', $kurir->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label>Nama</label>

                <input type="text"
                       name="name"
                       value="{{ $kurir->name }}"
                       class="form-control">

            </div>

            <div class="mb-3">

                <label>Email</label>

                <input type="email"
                       name="email"
                       value="{{ $kurir->email }}"
                       class="form-control">

            </div>

            <button class="btn btn-primary">

                Update

            </button>

        </form>

    </div>

</div>

@endsection