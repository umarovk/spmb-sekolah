@extends('partials.master')

@section('isihome')
    <!--begin::App Main-->
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <h1>APLIKASI PENDAFTARAN SISWA BARU</h1>
                    <P>SMK COKROAMINOTO WANADADI</P>
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="{{ route('tabelsiswa') }}">Siswa</a></li>
                            <li
                                class="breadcrumb-item active"
                                aria-current="page"
                            >Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <!--begin::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 1-->
                        <div class="small-box text-bg-primary">
                            <div class="inner">
                                <h3>{{ $jumlahData }}</h3>
                                <p>Siswa</p>
                            </div>
                            <svg
                                class="small-box-icon"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
                                ></path>
                            </svg>
                            <a
                                href="{{ route('siswa.create') }}"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                            >
                                Tambah Siswa <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 1-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 2-->
                        <div class="small-box text-bg-success">
                            <div class="inner">
                                <h3><sup
                                        class="fs-5">{{ \App\Helpers\FormatHelper::formatRupiah($totalPembayaran) }}</sup>
                                </h3>
                                <p>Pembayaran</p>
                            </div>
                            <svg
                                class="small-box-icon"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"
                                ></path>
                            </svg>
                            @if (auth()->user()->isAdmin() || auth()->user()->isTeller())
                                <a
                                    href="{{ route('payments.index') }}"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                >
                                    Info Pembayaran <i class="bi bi-link-45deg"></i>
                                </a>
                            @else
                                <a
                                    href="#"
                                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="bottom"
                                    title="Anda tidak memiliki akses ke halaman ini"
                                >
                                    Akses Terbatas <i class="bi bi-lock"></i>
                                </a>
                            @endif
                        </div>
                        <!--end::Small Box Widget 2-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 3-->
                        <div class="small-box text-bg-warning">
                            <div class="inner">
                                <h3>44</h3>
                                <p>User Registrations</p>
                            </div>
                            <svg
                                class="small-box-icon"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
                                ></path>
                            </svg>
                            <a
                                href="#"
                                class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                            >
                                More info <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 3-->
                    </div>
                    <!--end::Col-->
                    <div class="col-lg-3 col-6">
                        <!--begin::Small Box Widget 4-->
                        <div class="small-box text-bg-danger">
                            <div class="inner">
                                <h3>65</h3>
                                <p>Unique Visitors</p>
                            </div>
                            <svg
                                class="small-box-icon"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                    d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                                ></path>
                                <path
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                    d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                                ></path>
                            </svg>
                            <a
                                href="#"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                            >
                                More info <i class="bi bi-link-45deg"></i>
                            </a>
                        </div>
                        <!--end::Small Box Widget 4-->
                    </div>
                    <!--end::Col-->



                    <!-- Inside your card where you want to show the chart -->
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi Jurusan</h3>
                            </div>
                            <div class="card-body">
                                <div id="jurusanChart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Add this after your existing jurusan chart -->
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Distribusi Gender</h3>
                            </div>
                            <div class="card-body">
                                <div id="genderChart"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Add this after your gender chart -->
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Status Pembayaran</h3>
                            </div>
                            <div class="card-body">
                                <div id="paymentStatusChart"></div>
                            </div>
                        </div>
                    </div>

                    <!--end::Row-->
                    <!--begin::Row-->

                    <!-- /.row (main row) -->
                </div>
                <!--end::Container-->
            </div>
            <!--end::App Content-->
    </main>
    <!--end::App Main-->

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{{ $jurusanData['tkj'] }}, {{ $jurusanData['tsm'] }}],
                chart: {
                    width: '100%', // This will make it responsive within the col-3
                    height: 350, // Fixed height
                    type: 'pie',
                },
                labels: ['Teknik Komputer Jaringan', 'Teknik Sepeda Motor'],
                colors: ['#435ebe', '#fb7d44'],
                legend: {
                    position: 'bottom',
                    fontSize: '14px'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            fontSize: '12px'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Siswa"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#jurusanChart"), options);
            chart.render();

            // New gender chart
            var genderOptions = {
                series: [{{ $genderData['laki'] }}, {{ $genderData['perempuan'] }}],
                chart: {
                    width: '100%',
                    height: 350,
                    type: 'pie',
                },
                labels: ['Laki-laki', 'Perempuan'],
                colors: ['#3b82f6', '#ec4899'],
                legend: {
                    position: 'bottom',
                    fontSize: '14px'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            fontSize: '12px'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Siswa"
                        }
                    }
                }
            };

            var genderChart = new ApexCharts(document.querySelector("#genderChart"), genderOptions);
            genderChart.render();

            // Payment Status chart
            var paymentStatusOptions = {
                series: [{{ $paymentStatusData['sudah_bayar'] }}, {{ $paymentStatusData['belum_bayar'] }}],
                chart: {
                    width: '100%',
                    height: 350,
                    type: 'pie',
                },
                labels: ['Sudah Bayar', 'Belum Bayar'],
                colors: ['#10b981', '#ef4444'], // green for paid, red for unpaid
                legend: {
                    position: 'bottom',
                    fontSize: '14px'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            fontSize: '12px'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Siswa"
                        }
                    }
                }
            };

            var paymentStatusChart = new ApexCharts(document.querySelector("#paymentStatusChart"),
                paymentStatusOptions);
            paymentStatusChart.render();

            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endsection
