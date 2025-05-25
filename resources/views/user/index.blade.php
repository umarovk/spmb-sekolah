@extends('partials.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar User</h3>
                        <div class="card-tools">
                            <a
                                href="{{ route('users.create') }}"
                                class="btn btn-primary btn-sm"
                            >
                                <i class="bi bi-plus-circle"></i> Tambah User
                            </a>
                        </div>
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

                        <!-- Search and Filter Form -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <form
                                    action="{{ route('users.index') }}"
                                    method="GET"
                                    class="d-flex gap-2"
                                >
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            name="search"
                                            class="form-control"
                                            placeholder="Cari nama atau username..."
                                            value="{{ $search }}"
                                        >
                                        <button
                                            class="btn btn-primary"
                                            type="submit"
                                        >
                                            <i class="bi bi-search"></i> Cari
                                        </button>
                                        @if ($search || $role)
                                            <a
                                                href="{{ route('users.index') }}"
                                                class="btn btn-secondary"
                                            >
                                                <i class="bi bi-x-circle"></i> Reset
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form
                                    action="{{ route('users.index') }}"
                                    method="GET"
                                    class="d-flex gap-2"
                                >
                                    @if ($search)
                                        <input
                                            type="hidden"
                                            name="search"
                                            value="{{ $search }}"
                                        >
                                    @endif
                                    <select
                                        name="role"
                                        class="form-select"
                                        onchange="this.form.submit()"
                                    >
                                        <option value="">Semua Role</option>
                                        <option
                                            value="admin"
                                            {{ $role === 'admin' ? 'selected' : '' }}
                                        >Admin</option>
                                        <option
                                            value="teller"
                                            {{ $role === 'teller' ? 'selected' : '' }}
                                        >Teller</option>
                                        <option
                                            value="selektor"
                                            {{ $role === 'selektor' ? 'selected' : '' }}
                                        >Selektor</option>
                                        <option
                                            value="guest"
                                            {{ $role === 'guest' ? 'selected' : '' }}
                                        >Guest</option>
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-2">
                                <form
                                    action="{{ route('users.index') }}"
                                    method="GET"
                                    class="d-flex gap-2"
                                >
                                    @if ($search)
                                        <input
                                            type="hidden"
                                            name="search"
                                            value="{{ $search }}"
                                        >
                                    @endif
                                    @if ($role)
                                        <input
                                            type="hidden"
                                            name="role"
                                            value="{{ $role }}"
                                        >
                                    @endif
                                    <select
                                        name="perPage"
                                        class="form-select"
                                        onchange="this.form.submit()"
                                    >
                                        <option
                                            value="10"
                                            {{ $perPage == 10 ? 'selected' : '' }}
                                        >10 per halaman</option>
                                        <option
                                            value="25"
                                            {{ $perPage == 25 ? 'selected' : '' }}
                                        >25 per halaman</option>
                                        <option
                                            value="50"
                                            {{ $perPage == 50 ? 'selected' : '' }}
                                        >50 per halaman</option>
                                        <option
                                            value="100"
                                            {{ $perPage == 100 ? 'selected' : '' }}
                                        >100 per halaman</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Login Terakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td class="ps-3">
                                                {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'teller' ? 'success' : ($user->role === 'selektor' ? 'warning' : 'secondary')) }}"
                                                >
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($user->lastLogin())
                                                    @if (isset($user->lastLogin()->login_number))
                                                        Login #{{ $user->lastLogin()->login_number }}
                                                        <br>
                                                    @endif
                                                    {{ $user->lastLogin()->login_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                                                    WIB
                                                    <small class="text-muted d-block">
                                                        IP: {{ $user->lastLogin()->ip_address }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">Belum pernah login</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a
                                                        href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-outline-primary"
                                                    >
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if (auth()->user()->isAdmin() && $user->id !== auth()->id())
                                                        <form
                                                            action="{{ route('users.destroy', $user->id) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                type="submit"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')"
                                                            >
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="6"
                                                class="text-center py-4"
                                            >
                                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                                Tidak ada data pengguna
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer bg-white border-top border-light py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="text-muted small mb-0">
                                    Total: {{ $users->total() }} pengguna
                                </p>
                                <div>
                                    {{ $users->appends(['search' => $search])->links('vendor.pagination.custom') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
