@extends('partials.master')

@section('tambahbayar')
    <main class="app-main py-4">
        <div class="container"> <!-- Uses regular container -->
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <div class="card border-0 shadow-sm rounded-lg">
                        <div class="card-header bg-white border-0 pt-4 pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="card-title text-primary mb-0">Tambah Pembayaran</h4>
                                <span class="badge bg-light text-dark px-3 py-2 rounded-pill">{{ $siswa->namasiswa }}</span>
                            </div>
                        </div>
                        <div class="card-body px-4 pt-2 pb-4">
                            @if (session('error'))
                                <div
                                    class="alert alert-danger alert-dismissible fade show"
                                    role="alert"
                                >
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
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
                                action="{{ route('payments.store') }}"
                                method="POST"
                            >
                                @csrf
                                <input
                                    type="hidden"
                                    name="siswa_id"
                                    value="{{ $siswa->id }}"
                                >

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Nama Pembayaran</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-card-text text-muted"></i>
                                        </span>
                                        <input
                                            type="text"
                                            name="nama_pembayaran"
                                            class="form-control border-start-0 ps-0 @error('nama_pembayaran') is-invalid @enderror"
                                            placeholder="Masukkan nama pembayaran"
                                            value="{{ old('nama_pembayaran') }}"
                                            required
                                        >
                                        @error('nama_pembayaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Nominal</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            Rp
                                        </span>
                                        <input
                                            type="number"
                                            name="nominal"
                                            min="1"
                                            class="form-control border-start-0 ps-0 @error('nominal') is-invalid @enderror"
                                            placeholder="Masukkan nominal pembayaran"
                                            value="{{ old('nominal') }}"
                                            required
                                        >
                                        @error('nominal')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Tanggal Bayar</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-calendar-date text-muted"></i>
                                        </span>
                                        <input
                                            type="date"
                                            name="tanggal_bayar"
                                            class="form-control border-start-0 ps-0 @error('tanggal_bayar') is-invalid @enderror"
                                            value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                                            required
                                        >
                                        @error('tanggal_bayar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted small">Penerima Uang</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="bi bi-person text-muted"></i>
                                        </span>
                                        <input
                                            type="text"
                                            name="keterangan"
                                            class="form-control border-start-0 ps-0 bg-light"
                                            value="{{ auth()->user()->nama }}"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4 pt-2">
                                    <a
                                        href="{{ route('payments.index') }}"
                                        class="btn btn-outline-secondary px-4"
                                    >
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button
                                        type="submit"
                                        class="btn btn-primary px-4"
                                    >
                                        <i class="bi bi-save me-1"></i> Simpan
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
    </style>
@endpush
