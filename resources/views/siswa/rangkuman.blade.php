@extends('partials.master')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/rangkuman.css') }}"
    >
@endpush

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid px-3 px-md-2">
                <!-- Header Section -->
                <div class="header-section">
                    <h1 class="page-title">Dashboard Penerimaan Siswa</h1>
                    <p class="page-subtitle">Rangkuman data penerimaan siswa tahun ajaran 2025/2026</p>
                    <div
                        class="text-center"
                        style="color:#303030; font-size:1rem;"
                    >
                        Data saat ini pada {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y, H:i') }} WIB
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <!-- Total Pendaftar -->
                    <div class="stats-card bg-gradient-blue">
                        <div class="stats-content">
                            <h3 class="stats-title">Total Pendaftar</h3>
                            <div class="stats-numbers-row">
                                <div class="main-number">{{ $totalPendaftar['total'] }}</div>
                                <div class="sub-numbers">
                                    <span class="sub-number tkj">{{ $totalPendaftar['tkj'] }}<div class="sub-label">TKJ
                                        </div></span>
                                    <span class="sub-number tsm">{{ $totalPendaftar['tsm'] }}<div class="sub-label">TSM
                                        </div></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Siswa Diterima -->
                    <div class="stats-card bg-gradient-blue">
                        <div class="stats-content">
                            <h3 class="stats-title">Siswa Diterima</h3>
                            <div class="stats-numbers-row">
                                <div class="main-number">{{ $siswaDiterima['total'] }}</div>
                                <div class="sub-numbers">
                                    <span class="sub-number tkj">{{ $siswaDiterima['tkj'] }}<div class="sub-label">TKJ</div>
                                    </span>
                                    <span class="sub-number tsm">{{ $siswaDiterima['tsm'] }}<div class="sub-label">TSM</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Siswa Ditolak -->
                    <div class="stats-card bg-gradient-blue">
                        <div class="stats-content">
                            <h3 class="stats-title">Siswa Ditolak</h3>
                            <div class="stats-numbers-row">
                                <div class="main-number">{{ $siswaDitolak['total'] }}</div>
                                <div class="sub-numbers">
                                    <span class="sub-number tkj">{{ $siswaDitolak['tkj'] }}<div class="sub-label">TKJ</div>
                                    </span>
                                    <span class="sub-number tsm">{{ $siswaDitolak['tsm'] }}<div class="sub-label">TSM</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Siswa Dipertimbangkan -->
                    <div class="stats-card bg-gradient-blue">
                        <div class="stats-content">
                            <h3 class="stats-title">Siswa Dipertimbangkan</h3>
                            <div class="stats-numbers-row">
                                <div class="main-number">{{ $siswaDipertimbangkan['total'] }}</div>
                                <div class="sub-numbers">
                                    <span class="sub-number tkj">{{ $siswaDipertimbangkan['tkj'] }}<div class="sub-label">
                                            TKJ</div>
                                    </span>
                                    <span class="sub-number tsm">{{ $siswaDipertimbangkan['tsm'] }}<div class="sub-label">
                                            TSM</div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Siswa Belum Seleksi -->
                    <div class="stats-card bg-gradient-blue">
                        <div class="stats-content">
                            <h3 class="stats-title">Belum Seleksi</h3>
                            <div class="stats-numbers-row">
                                <div class="main-number">{{ $siswaBelumSeleksi['total'] }}</div>
                                <div class="sub-numbers">
                                    <span class="sub-number tkj">{{ $siswaBelumSeleksi['tkj'] }}<div class="sub-label">TKJ
                                        </div></span>
                                    <span class="sub-number tsm">{{ $siswaBelumSeleksi['tsm'] }}<div class="sub-label">TSM
                                        </div></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Siswa Sudah DU -->
                    <div class="stats-card bg-gradient-blue">
                        <div class="stats-content">
                            <h3 class="stats-title">Sudah Daftar Ulang</h3>
                            <div class="stats-numbers-row">
                                <div class="main-number">{{ $siswaSudahDU['total'] }}</div>
                                <div class="sub-numbers">
                                    <span class="sub-number tkj">{{ $siswaSudahDU['tkj'] }}<div class="sub-label">TKJ
                                        </div></span>
                                    <span class="sub-number tsm">{{ $siswaSudahDU['tsm'] }}<div class="sub-label">TSM

                                        </div>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Total Transaksi DU -->
                    <div class="stats-card bg-gradient-blue">
                        <div class="stats-content">
                            <h3 class="stats-title">Total Transaksi Daftar Ulang</h3>
                            <div class="stats-numbers">
                                <div class="main-number">Rp {{ number_format($totalTransaksiDU, 0, ',', '.') }}</div>
                                <div class="sub-numbers">
                                    <span>Total pemasukan dari daftar ulang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
