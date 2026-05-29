@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <div class="d-flex justify-content-between mb-3">

            <h3>Data Kurir</h3>

            <a href="{{ route('kurir.create') }}"
               class="btn btn-primary">

                Tambah Kurir

            </a>

        </div>

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <table class="table table-bordered">

            <thead>
<tr>
    <th>Nama</th>
    <th>Email</th>
    <th width="180">Aksi</th>
</tr>
</thead>

<tbody>

@foreach($kurir as $k)

<tr>

    <td>{{ $k->name }}</td>

    <td>{{ $k->email }}</td>

    <td>

        <a href="{{ route('kurir.edit', $k->id) }}"
           class="btn btn-warning btn-sm">

            Edit

        </a>

        <form action="{{ route('kurir.destroy', $k->id) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus kurir ini?')">

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