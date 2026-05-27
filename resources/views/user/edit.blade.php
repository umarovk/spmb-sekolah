@extends('partials.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit User</h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (auth()->user()->isAdmin())
                            <div class="alert alert-info d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div>
                                    <strong>Password saat ini:</strong>
                                    @if ($user->password_plain)
                                        <span
                                            id="current-password-text"
                                            data-password="{{ $user->password_plain }}"
                                        >••••••••</span>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-secondary ms-2"
                                            id="toggle-current-password"
                                        >
                                            <i
                                                class="bi bi-eye"
                                                id="toggle-current-password-icon"
                                            ></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted">(belum tersedia — password lama dibuat sebelum fitur ini aktif)</span>
                                    @endif
                                </div>
                                <form
                                    action="{{ route('users.reset-password', $user->id) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Reset password user {{ $user->nama }} menjadi guru123456?')"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-warning"
                                    >
                                        <i class="bi bi-key"></i> Reset ke "guru123456"
                                    </button>
                                </form>
                            </div>
                        @endif

                        <form
                            action="{{ route('users.update', $user) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="username">Username</label>
                                <input
                                    type="text"
                                    class="form-control @error('username') is-invalid @enderror"
                                    id="username"
                                    name="username"
                                    value="{{ old('username', $user->username) }}"
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
                                    value="{{ old('nama', $user->nama) }}"
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
                                    value="{{ old('email', $user->email) }}"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                                <input
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                >
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="password_confirmation">Konfirmasi Password Baru</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
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
                                        {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}
                                    >Admin</option>
                                    <option
                                        value="teller"
                                        {{ old('role', $user->role) == 'teller' ? 'selected' : '' }}
                                    >Teller</option>
                                    <option
                                        value="selektor"
                                        {{ old('role', $user->role) == 'selektor' ? 'selected' : '' }}
                                    >Selektor</option>
                                    <option
                                        value="guest"
                                        {{ old('role', $user->role) == 'guest' ? 'selected' : '' }}
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
                                >Update</button>
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

    @if (auth()->user()->isAdmin())
        <script>
            (function () {
                const toggleBtn = document.getElementById('toggle-current-password');
                if (!toggleBtn) return;
                const textEl = document.getElementById('current-password-text');
                const iconEl = document.getElementById('toggle-current-password-icon');
                let visible = false;
                toggleBtn.addEventListener('click', function () {
                    visible = !visible;
                    if (visible) {
                        textEl.textContent = textEl.dataset.password;
                        iconEl.classList.remove('bi-eye');
                        iconEl.classList.add('bi-eye-slash');
                    } else {
                        textEl.textContent = '••••••••';
                        iconEl.classList.remove('bi-eye-slash');
                        iconEl.classList.add('bi-eye');
                    }
                });
            })();
        </script>
    @endif
@endsection
