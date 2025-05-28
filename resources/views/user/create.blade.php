@extends('partials.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tambah User Baru</h3>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('users.store') }}"
                            method="POST"
                        >
                            @csrf
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input
                                    type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    id="username"
                                    name="username"
                                    value="{{ old('username') }}"
                                    required
                                >
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="nama">Nama Lengkap</label>
                                <input
                                    type="text"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    id="nama"
                                    name="nama"
                                    value="{{ old('nama') }}"
                                    required
                                >
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    required
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    required
                                >
                            </div>

                            <div class="form-group mb-3">
                                <label for="role">Role</label>
                                <select
                                    class="form-control @error('role') is-invalid @enderror"
                                    id="role"
                                    name="role"
                                    required
                                >
                                    <option value="">Pilih Role</option>
                                    <option
                                        value="admin"
                                        {{ old('role') == 'admin' ? 'selected' : '' }}
                                    >Admin</option>
                                    <option
                                        value="teller"
                                        {{ old('role') == 'teller' ? 'selected' : '' }}
                                    >Teller</option>
                                    <option
                                        value="selektor"
                                        {{ old('role') == 'selektor' ? 'selected' : '' }}
                                    >Selektor</option>
                                    <option
                                        value="guest"
                                        {{ old('role') == 'guest' ? 'selected' : '' }}
                                    >Guest</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >Simpan</button>
                                <a
                                    href="{{ route('users.index') }}"
                                    class="btn btn-secondary"
                                >Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
