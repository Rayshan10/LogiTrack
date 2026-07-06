@extends('layouts.app')

@section('title', 'Import Dataset')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-body">

        <h2 class="fw-bold mb-2">
            Import Dataset Kaggle
        </h2>

        <p class="text-muted mb-4">
            Upload file CSV hasil download dari Kaggle.
        </p>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.import.store') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    File Dataset (.csv)
                </label>
                <input
                    type="file"
                    class="form-control"
                    name="file"
                    accept=".csv"
                    required>
            </div>
            <button class="btn btn-primary">
                <i class="bi bi-upload"></i>
                Upload Dataset
            </button>
        </form>
    </div>
</div>

@endsection