@extends('layouts.app')

@section('content')

<div class="card card-dashboard">

    <div class="card-body">

        <h3 class="mb-4">
            Profile User
        </h3>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success">
                Profile berhasil diperbarui
            </div>
        @endif

        <form method="post"
                action="{{ route('profile.update') }}">

            @csrf
            @method('patch')

            <div class="mb-3">
                <label class="form-label">
                    Nama
                </label>

                <input type="text"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">
                    Email
                </label>

                <input type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        class="form-control">
            </div>

            <button type="submit"
                    class="btn btn-primary">
                Simpan Perubahan
            </button>

        </form>

        <hr class="my-4">

        <h5>Ubah Password</h5>

        <form method="post"
                action="{{ route('password.update') }}">

            @csrf
            @method('put')

            <div class="mb-3">
                <label>Password Lama</label>

                <input type="password"
                        name="current_password"
                        class="form-control">
            </div>

            <div class="mb-3">
                <label>Password Baru</label>

                <input type="password"
                        name="password"
                        class="form-control">
            </div>

            <div class="mb-3">
                <label>Konfirmasi Password</label>

                <input type="password"
                        name="password_confirmation"
                        class="form-control">
            </div>

            <button type="submit"
                    class="btn btn-warning">
                Update Password
            </button>

        </form>

    </div>

</div>

@endsection