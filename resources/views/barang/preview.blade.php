@extends('layouts.app')

@section('title','Preview Dataset')

@section('content')

<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="fw-bold mb-2">
            Preview Dataset Kaggle
        </h2>

        <p class="text-muted">
            Total Data :
            <strong>{{ number_format($totalRows) }}</strong>
            baris
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        @foreach($header as $head)
                            <th>{{ $head }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($preview as $row)
                        <tr>
                            @foreach($row as $col)
                                <td>{{ $col }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <form
                action="{{ route('barang.import.process') }}"
                method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label fw-bold">
                            Jumlah Import
                        </label>
                        <select name="limit" class="form-select">
                            <option value="100">100 Data</option>
                            <option value="500">500 Data</option>
                            <option value="1000"`selected>1000 Data</option>
                            <option value="5000">5000 Data</option>
                            <option value="0">Semua Data</option>
                        </select>
                    </div>
                </div>
                <button class="btn btn-success mt-4">
                    <i class="bi bi-database-fill-add"></i>
                    Import Dataset
                </button>
            </form>
        </div>
    </div>
</div>
@endsection