@extends('partials.master')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/rangkuman.css') }}"
    >
@endpush

@section('content')
    <main class="rangkuman-main">
        <div class="container-fluid">
            <!-- Header -->
            <div class="rangkuman-header">
                <div class="rangkuman-header-icon">
                    <i class="bi bi-bar-chart-line-fill"></i>
                </div>
                <div class="rangkuman-header-text">
                    <h1 class="rangkuman-title">Dashboard Penerimaan Siswa</h1>
                    <p class="rangkuman-subtitle">Rangkuman data penerimaan siswa tahun ajaran 2025/2026</p>
                    <div class="rangkuman-timestamp">
                        <i class="bi bi-clock"></i>
                        Data per {{ \Carbon\Carbon::now('Asia/Jakarta')->format('d F Y, H:i') }} WIB
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="rangkuman-grid">
                <!-- Total Pendaftar -->
                <div class="r-card r-card-primary">
                    <div class="r-card-head">
                        <div class="r-icon"><i class="bi bi-people-fill"></i></div>
                        <h3 class="r-title">Total Pendaftar</h3>
                    </div>
                    <div class="r-main">{{ $totalPendaftar['total'] }}</div>
                    <div class="r-sub">
                        <div class="r-chip r-chip-tkj">
                            <span class="r-chip-num">{{ $totalPendaftar['tkj'] }}</span>
                            <span class="r-chip-lbl">TKJ</span>
                        </div>
                        <div class="r-chip r-chip-tsm">
                            <span class="r-chip-num">{{ $totalPendaftar['tsm'] }}</span>
                            <span class="r-chip-lbl">TSM</span>
                        </div>
                    </div>
                </div>

                <!-- Siswa Diterima -->
                <div class="r-card r-card-success">
                    <div class="r-card-head">
                        <div class="r-icon"><i class="bi bi-check-circle-fill"></i></div>
                        <h3 class="r-title">Siswa Diterima</h3>
                    </div>
                    <div class="r-main">{{ $siswaDiterima['total'] }}</div>
                    <div class="r-sub">
                        <div class="r-chip r-chip-tkj">
                            <span class="r-chip-num">{{ $siswaDiterima['tkj'] }}</span>
                            <span class="r-chip-lbl">TKJ</span>
                        </div>
                        <div class="r-chip r-chip-tsm">
                            <span class="r-chip-num">{{ $siswaDiterima['tsm'] }}</span>
                            <span class="r-chip-lbl">TSM</span>
                        </div>
                    </div>
                </div>

                <!-- Siswa Ditolak -->
                <div class="r-card r-card-danger">
                    <div class="r-card-head">
                        <div class="r-icon"><i class="bi bi-x-circle-fill"></i></div>
                        <h3 class="r-title">Siswa Ditolak</h3>
                    </div>
                    <div class="r-main">{{ $siswaDitolak['total'] }}</div>
                    <div class="r-sub">
                        <div class="r-chip r-chip-tkj">
                            <span class="r-chip-num">{{ $siswaDitolak['tkj'] }}</span>
                            <span class="r-chip-lbl">TKJ</span>
                        </div>
                        <div class="r-chip r-chip-tsm">
                            <span class="r-chip-num">{{ $siswaDitolak['tsm'] }}</span>
                            <span class="r-chip-lbl">TSM</span>
                        </div>
                    </div>
                </div>

                <!-- Siswa Dipertimbangkan -->
                <div class="r-card r-card-warning">
                    <div class="r-card-head">
                        <div class="r-icon"><i class="bi bi-hourglass-split"></i></div>
                        <h3 class="r-title">Dipertimbangkan</h3>
                    </div>
                    <div class="r-main">{{ $siswaDipertimbangkan['total'] }}</div>
                    <div class="r-sub">
                        <div class="r-chip r-chip-tkj">
                            <span class="r-chip-num">{{ $siswaDipertimbangkan['tkj'] }}</span>
                            <span class="r-chip-lbl">TKJ</span>
                        </div>
                        <div class="r-chip r-chip-tsm">
                            <span class="r-chip-num">{{ $siswaDipertimbangkan['tsm'] }}</span>
                            <span class="r-chip-lbl">TSM</span>
                        </div>
                    </div>
                </div>

                <!-- Siswa Belum Seleksi -->
                <div class="r-card r-card-neutral">
                    <div class="r-card-head">
                        <div class="r-icon"><i class="bi bi-clipboard-data"></i></div>
                        <h3 class="r-title">Belum Seleksi</h3>
                    </div>
                    <div class="r-main">{{ $siswaBelumSeleksi['total'] }}</div>
                    <div class="r-sub">
                        <div class="r-chip r-chip-tkj">
                            <span class="r-chip-num">{{ $siswaBelumSeleksi['tkj'] }}</span>
                            <span class="r-chip-lbl">TKJ</span>
                        </div>
                        <div class="r-chip r-chip-tsm">
                            <span class="r-chip-num">{{ $siswaBelumSeleksi['tsm'] }}</span>
                            <span class="r-chip-lbl">TSM</span>
                        </div>
                    </div>
                </div>

                <!-- Sudah Daftar Ulang -->
                <div class="r-card r-card-info">
                    <div class="r-card-head">
                        <div class="r-icon"><i class="bi bi-person-check-fill"></i></div>
                        <h3 class="r-title">Sudah Daftar Ulang</h3>
                    </div>
                    <div class="r-main">{{ $siswaSudahDU['total'] }}</div>
                    <div class="r-sub">
                        <div class="r-chip r-chip-tkj">
                            <span class="r-chip-num">{{ $siswaSudahDU['tkj'] }}</span>
                            <span class="r-chip-lbl">TKJ</span>
                        </div>
                        <div class="r-chip r-chip-tsm">
                            <span class="r-chip-num">{{ $siswaSudahDU['tsm'] }}</span>
                            <span class="r-chip-lbl">TSM</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi DU (Wide Card) -->
            <div class="r-card-wide">
                <div class="r-wide-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="r-wide-body">
                    <h3 class="r-wide-title">Total Transaksi Daftar Ulang</h3>
                    <div class="r-wide-amount">Rp {{ number_format($totalTransaksiDU, 0, ',', '.') }}</div>
                    <p class="r-wide-note">Total pemasukan dari pembayaran daftar ulang</p>
                </div>
            </div>
        </div>
    </main>
@endsection
