@extends('partials.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                {{-- CARD --}}
                <div class="card">

                    {{-- CARD HEADER --}}
                    <div class="card-header">
                        <div class="container py-4">
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-8">
                                    <h1 class="fw-light text-primary mb-0 fs-3">Edit Data Pengambilan Bahan</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD BODY --}}
                    <div class="card-body">
                        <form
                            action="{{ route('bahan.update', $bahan->id) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="siswa_id"
                                            class="form-label"
                                        >Siswa</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            value="{{ $bahan->siswa->namasiswa }}"
                                            readonly
                                        >
                                        <input
                                            type="hidden"
                                            name="siswa_id"
                                            value="{{ $bahan->siswa_id }}"
                                        >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="tanggal_pengambilan"
                                            class="form-label"
                                        >Tanggal Pengambilan</label>
                                        <input
                                            type="date"
                                            name="tanggal_pengambilan"
                                            id="tanggal_pengambilan"
                                            class="form-control @error('tanggal_pengambilan') is-invalid @enderror"
                                            value="{{ old('tanggal_pengambilan', $bahan->tanggal_pengambilan->format('Y-m-d')) }}"
                                            required
                                        >
                                        @error('tanggal_pengambilan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="nama_bahan"
                                            class="form-label"
                                        >Nama Bahan</label>
                                        <input
                                            type="text"
                                            name="nama_bahan"
                                            id="nama_bahan"
                                            class="form-control @error('nama_bahan') is-invalid @enderror"
                                            value="{{ old('nama_bahan', $bahan->nama_bahan) }}"
                                            required
                                        >
                                        @error('nama_bahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label
                                            for="jumlah"
                                            class="form-label"
                                        >Jumlah</label>
                                        <input
                                            type="number"
                                            name="jumlah"
                                            id="jumlah"
                                            class="form-control @error('jumlah') is-invalid @enderror"
                                            value="{{ old('jumlah', $bahan->jumlah) }}"
                                            min="1"
                                            required
                                        >
                                        @error('jumlah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label
                                            for="keterangan"
                                            class="form-label"
                                        >Keterangan</label>
                                        <textarea
                                            name="keterangan"
                                            id="keterangan"
                                            class="form-control @error('keterangan') is-invalid @enderror"
                                            rows="3"
                                        >{{ old('keterangan', $bahan->keterangan) }}</textarea>
                                        @error('keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a
                                            href="{{ route('bahan.index') }}"
                                            class="btn btn-secondary"
                                        >
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            <i class="bi bi-save"></i> Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .invalid-feedback {
            font-size: 0.875em;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn i {
            font-size: 1rem;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-title {
            margin-bottom: 0;
            color: #212529;
        }

        /* Add responsive styles */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .card-header .row {
                flex-direction: column;
            }

            .justify-content-md-end {
                justify-content: flex-start !important;
            }

            .card-body {
                padding: 1rem;
            }
        }
    </style>
@endpush
