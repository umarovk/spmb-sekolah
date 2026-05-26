@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Backup Database</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li
                                class="breadcrumb-item active"
                                aria-current="page"
                            >Backup Database</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Database Backup Manager</h4>
                            </div>
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title">Backup menggunakan MySQL Dump</h5>
                                                <p class="card-text">Metode ini menggunakan mysqldump command dan lebih
                                                    cepat untuk database besar.</p>
                                                <a
                                                    href="{{ route('admin.backup.generate') }}"
                                                    class="btn btn-primary"
                                                >
                                                    <i class="bi bi-download"></i> Download Database Backup
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card bg-light">
                                            <div class="card-body">
                                                <h5 class="card-title">Backup menggunakan PHP</h5>
                                                <p class="card-text">Metode alternatif menggunakan PHP murni (jika mysqldump
                                                    tidak tersedia).</p>
                                                <a
                                                    href="{{ route('admin.backup.generate-php') }}"
                                                    class="btn btn-secondary"
                                                >
                                                    <i class="bi bi-download"></i> Download PHP Backup
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info">
                                    <h5><i class="bi bi-info-circle"></i> Informasi Backup Database</h5>
                                    <p>Beberapa informasi penting tentang backup database:</p>
                                    <ul>
                                        <li>Backup akan mengunduh seluruh struktur dan data dalam format SQL.</li>
                                        <li>Proses ini mungkin memakan waktu untuk database yang besar.</li>
                                        <li>File backup akan langsung diunduh ke perangkat Anda.</li>
                                        <li>Pastikan untuk menyimpan file backup di tempat yang aman.</li>
                                    </ul>
                                </div>

                                <hr class="my-4">

                                <div class="card border-danger">
                                    <div class="card-header bg-danger text-white">
                                        <h5 class="card-title mb-0"><i class="bi bi-arrow-counterclockwise"></i> Restore Database</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-warning">
                                            <strong><i class="bi bi-exclamation-triangle"></i> Peringatan:</strong>
                                            Restore akan <strong>menimpa seluruh data</strong> pada database saat ini dengan
                                            isi dari file backup yang diunggah. Aksi ini <strong>tidak dapat dibatalkan</strong>.
                                            Pastikan Anda sudah membuat backup terbaru sebelum melanjutkan.
                                        </div>

                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $err)
                                                        <li>{{ $err }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <form
                                            action="{{ route('admin.backup.restore') }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            id="restoreForm"
                                        >
                                            @csrf
                                            <div class="mb-3">
                                                <label
                                                    for="backup_file"
                                                    class="form-label"
                                                >File Backup (.sql)</label>
                                                <input
                                                    type="file"
                                                    class="form-control"
                                                    id="backup_file"
                                                    name="backup_file"
                                                    accept=".sql,.txt"
                                                    required
                                                >
                                                <small class="form-text text-muted">Maksimal 100 MB. Hanya menerima file
                                                    .sql atau .txt</small>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    id="konfirmasi"
                                                    name="konfirmasi"
                                                    value="1"
                                                    required
                                                >
                                                <label
                                                    class="form-check-label"
                                                    for="konfirmasi"
                                                >Saya mengerti bahwa data lama akan ditimpa dan tidak dapat
                                                    dikembalikan.</label>
                                            </div>

                                            <button
                                                type="submit"
                                                class="btn btn-danger"
                                                onclick="return confirm('Yakin ingin restore database? Seluruh data lama akan ditimpa.');"
                                            >
                                                <i class="bi bi-upload"></i> Restore Database
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
