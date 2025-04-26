@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Pembayaran untuk {{ $siswa->namasiswa }}</h3>
                </div>
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
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

                        <div class="mb-3">
                            <label class="form-label">Nama Pembayaran</label>
                            <input
                                type="text"
                                name="nama_pembayaran"
                                class="form-control @error('nama_pembayaran') is-invalid @enderror"
                                value="{{ old('nama_pembayaran') }}"
                                required
                            >
                            @error('nama_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nominal</label>
                            <input
                                type="number"
                                name="nominal"
                                class="form-control @error('nominal') is-invalid @enderror"
                                value="{{ old('nominal') }}"
                                required
                            >
                            @error('nominal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Bayar</label>
                            <input
                                type="date"
                                name="tanggal_bayar"
                                class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                                required
                            >
                            @error('tanggal_bayar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea
                                name="keterangan"
                                class="form-control"
                            >{{ old('keterangan') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a
                                href="{{ route('payments.index') }}"
                                class="btn btn-secondary"
                            >
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
