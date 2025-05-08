@extends('partials.master')

@section('editbayar')
    <main class="app-main">
        <div class="container-fluid py-4"> {{-- Changed to container-fluid --}}
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <a
                                    href="{{ route('payments.show', $bayar->siswa_id) }}"
                                    class="btn btn-link text-decoration-none p-0 me-3"
                                >
                                    <i class="bi bi-arrow-left"></i>
                                </a>
                                <h5 class="card-title m-0 text-primary">Edit Pembayaran</h5>
                            </div>
                            <p class="text-muted small mb-0 mt-2">{{ $bayar->siswa->namasiswa }}</p>
                        </div>

                        <div class="card-body py-4">
                            @if (session('error'))
                                <div
                                    class="alert alert-danger alert-dismissible fade show"
                                    role="alert"
                                >
                                    {{ session('error') }}
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="alert"
                                        aria-label="Close"
                                    ></button>
                                </div>
                            @endif

                            <form
                                action="{{ route('payments.update', $bayar->id) }}"
                                method="POST"
                            >
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Kode Pembayaran</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-lg bg-light"
                                        value="{{ $bayar->kode_bayar }}"
                                        readonly
                                    >
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Nama Pembayaran</label>
                                    <input
                                        type="text"
                                        name="nama_pembayaran"
                                        class="form-control form-control-lg @error('nama_pembayaran') is-invalid @enderror"
                                        value="{{ old('nama_pembayaran', $bayar->nama_pembayaran) }}"
                                        required
                                    >
                                    @error('nama_pembayaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Nominal (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input
                                            type="text"
                                            name="nominal"
                                            class="form-control border-start-0 ps-0 @error('nominal') is-invalid @enderror"
                                            placeholder="Masukkan nominal pembayaran"
                                            value="{{ old('nominal', $bayar->nominal) }}"
                                            pattern="[0-9]*"
                                            inputmode="numeric"
                                            min="1"
                                            required
                                        >

                                        @error('nominal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Tanggal Bayar</label>
                                    <input
                                        type="date"
                                        name="tanggal_bayar"
                                        class="form-control form-control-lg @error('tanggal_bayar') is-invalid @enderror"
                                        value="{{ old('tanggal_bayar', $bayar->tanggal_bayar->format('Y-m-d')) }}"
                                        required
                                    >
                                    @error('tanggal_bayar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Penerima Uang</label>
                                    <input
                                        type="text"
                                        name="keterangan"
                                        class="form-control form-control-lg"
                                        value="{{ old('keterangan', $bayar->keterangan) }}"
                                    >
                                </div>

                                <div class="d-grid gap-2 mt-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-lg py-2"
                                    >
                                        <i class="bi bi-check2-circle me-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection



@push('styles')
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .input-group-text {
            box-shadow: none;
            border-color: #ced4da;
        }

        .input-group-text {
            color: #6c757d;
        }

        .btn {
            border-radius: 5px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #5469d4;
            border-color: #5469d4;
        }

        .btn-primary:hover {
            background-color: #4a5bc2;
            border-color: #4a5bc2;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #ced4da;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            border-color: #ced4da;
            color: #5a6268;
        }

        .badge {
            font-weight: 500;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .card-body {
                padding: 1rem;
            }

            .container-fluid {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }

        /* Main layout */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* Sidebar styles */
        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            background: #fff;
            z-index: 1040;
            transition: all 0.3s ease;
        }

        /* Main content wrapper */
        .dashboard-main {
            flex: 1;
            margin-left: 220px;
            width: calc(100% - 280px);
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Sidebar collapsed state */
        .sidebar-collapsed .app-sidebar {
            left: -250px;
        }

        .sidebar-collapsed .dashboard-main {
            margin-left: 0;
            width: 100%;
        }

        /* Sidebar toggle button styles */
        #sidebarToggler,
        #sidebarTogglerDesktop {
            cursor: pointer;
            padding: 0.5rem;
            margin-right: 0.5rem;
        }

        #sidebarToggler i,
        #sidebarTogglerDesktop i {
            transition: transform 0.3s ease;
        }

        .sidebar-collapsed #sidebarTogglerDesktop i {
            transform: rotate(180deg);
        }

        /* Responsive adjustments */
        @media (max-width: 991.98px) {
            .app-sidebar {
                left: -280px;
            }

            .dashboard-main {
                margin-left: 0;
                width: 100%;
            }

            .app-sidebar.show {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1030;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }


        /* Content container */
        .dashboard-content {
            padding: 1rem;
            width: 100%;
        }

        /* Header styles */
        .dashboard-header {
            position: sticky;
            top: 0;
            background: #fff;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .1);
            z-index: 1020;
            width: 100%;
        }

        /* Custom scrollbar for sidebar */
        .app-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .app-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .app-sidebar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .app-sidebar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@endpush
