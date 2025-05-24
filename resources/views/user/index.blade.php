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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                            </td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->nama }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'teller' ? 'primary' : ($user->role === 'selektor' ? 'success' : 'warning')) }}"
                                                >
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a
                                                    href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-warning btn-sm"
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
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                                        >
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="6"
                                                class="text-center"
                                            >Tidak ada data</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari
                                    {{ $users->total() }} data
                                </div>
                                <div>
                                    {{ $users->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
