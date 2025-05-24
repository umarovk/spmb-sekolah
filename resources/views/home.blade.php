@extends('partials.master')

@section('isihome')
    <!-- Content Section -->
    <div class="dashboard-content">
        <div class="container-fluid">
            <!-- Stats Cards Row -->
            <div class="row stats-row">
                <!-- Siswa Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card siswa-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="stats-number">{{ $jumlahData }}</h2>
                                <p class="stats-label">Total Siswa</p>
                            </div>
                            <div class="stats-icon siswa-icon">
                                <a
                                    href="{{ route('tabelsiswa') }}"
                                    class="nav-link rounded-pill py-2 {{ Request::routeIs('tabelsiswa*', 'siswa.*') ? 'active bg-light text-primary' : 'text-primary' }}"
                                > <i class="bi bi-people-fill"></i>
                                </a>
                            </div>
                        </div>
                        <div class="stats-action">
                            <a
                                href="{{ route('siswa.create') }}"
                                class="btn-action siswa-action"
                            >
                                Tambah Siswa <i class="bi bi-plus-circle"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Data Siswa Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card data-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="stats-number">{{ $jumlahData }}</h2>
                                <p class="stats-label">Data Terdaftar</p>
                            </div>
                            <div class="stats-icon data-icon">
                                <a
                                    href="{{ route('tabelsiswa') }}"
                                    class="nav-link rounded-pill py-2 {{ Request::routeIs('tabelsiswa*', 'siswa.*') ? 'active bg-light text-primary' : 'text-warning' }}"
                                >
                                    <i class="bi bi-file-earmark-text"></i>
                                </a>
                            </div>
                        </div>
                        <div class="stats-action">
                            <a
                                href="{{ route('siswa.export') }}"
                                class="btn-action data-action"
                            >
                                Download Excel <i class="bi bi-download"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card payment-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="stats-number">{{ \App\Helpers\FormatHelper::formatRupiah($totalPembayaran) }}
                                </h2>
                                <p class="stats-label">Total Pembayaran</p>
                            </div>
                            <div class="stats-icon payment-icon">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                        <div class="stats-action">
                            @if (auth()->user()->isAdmin() || auth()->user()->isTeller())
                                <a
                                    href="{{ route('payments.index') }}"
                                    class="btn-action payment-action"
                                >
                                    Info Pembayaran <i class="bi bi-info-circle"></i>
                                </a>
                            @else
                                <a
                                    href="#"
                                    class="btn-action disabled"
                                >
                                    Akses Terbatas <i class="bi bi-lock"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Transaksi Card -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card transaction-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="stats-number">{{ $pembayaran->count() }}</h2>
                                <p class="stats-label">Total Transaksi</p>
                            </div>
                            <div class="stats-icon transaction-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                        <div class="stats-action">
                            @if (auth()->user()->isAdmin() || auth()->user()->isTeller())
                                <a
                                    href="{{ route('payments.export') }}"
                                    class="btn-action transaction-action"
                                >
                                    Download Data <i class="bi bi-download"></i>
                                </a>
                            @else
                                <a
                                    href="#"
                                    class="btn-action disabled"
                                >
                                    Akses Terbatas <i class="bi bi-lock"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row charts-row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="chart-card h-100">
                        <div class="chart-header">
                            <h3>Distribusi Jurusan</h3>
                        </div>
                        <div class="chart-body">
                            <div id="jurusanChart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="chart-card h-100">
                        <div class="chart-header">
                            <h3>Distribusi Gender</h3>
                        </div>
                        <div class="chart-body">
                            <div id="genderChart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="chart-card h-100">
                        <div class="chart-header">
                            <h3>Status Pembayaran</h3>
                        </div>
                        <div class="chart-body">
                            <div id="paymentChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Stats Row -->
            <div class="row stats-row">
                <!-- Daily Registration Card -->
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="stats-number">{{ $dailyRegistrations->sum('count') }}</h2>
                                <p class="stats-label">Total Pendaftar Keseluruhan</p>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-person-plus-fill text-success"></i>
                            </div>
                        </div>
                        <div class="stats-details mt-3">
                            <h5>Detail per Hari:</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jumlah Pendaftar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyRegistrations as $registration)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($registration['date'])->format('d M Y') }}
                                                </td>
                                                <td>{{ $registration['count'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Payment Card -->
                <div class="col-lg-6 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="stats-number">
                                    {{ \App\Helpers\FormatHelper::formatRupiah($dailyPayments->sum('total')) }}</h2>
                                <p class="stats-label">Total Pembayaran keseluruhan</p>
                            </div>
                            <div class="stats-icon">
                                <i class="bi bi-cash-stack text-primary"></i>
                            </div>
                        </div>
                        <div class="stats-details mt-3">
                            <h5>Detail per Hari:</h5>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Total Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dailyPayments as $payment)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($payment['date'])->format('d M Y') }}</td>
                                                <td>{{ \App\Helpers\FormatHelper::formatRupiah($payment['total']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const chartData = {
            jurusan: {
                tkj: {{ $jurusanData['tkj'] }},
                tsm: {{ $jurusanData['tsm'] }}
            },
            gender: {
                laki: {{ $genderData['laki'] }},
                perempuan: {{ $genderData['perempuan'] }}
            },
            payment: {
                sudah_bayar: {{ $paymentStatusData['sudah_bayar'] }},
                belum_bayar: {{ $paymentStatusData['belum_bayar'] }}
            }
        };
    </script>
    {{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
@endpush
