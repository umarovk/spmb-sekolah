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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
