@extends('partials.master')

@section('content')
    <main class="app-main bg-light">
        <div class="container py-4">
            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-light text-primary mb-0 fs-3">Edit Pembayaran</h1>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    <form
                        action="{{ route('payments.update', $payment->id) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label
                                for="nominal"
                                class="form-label"
                            >Nominal Pembayaran</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input
                                    type="number"
                                    class="form-control @error('nominal') is-invalid @enderror"
                                    id="nominal"
                                    name="nominal"
                                    value="{{ old('nominal', $payment->nominal) }}"
                                    required
                                >
                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label
                                for="tanggal"
                                class="form-label"
                            >Tanggal Pembayaran</label>
                            <input
                                type="date"
                                class="form-control @error('tanggal') is-invalid @enderror"
                                id="tanggal"
                                name="tanggal"
                                value="{{ old('tanggal', $payment->tanggal) }}"
                                required
                            >
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label
                                for="keterangan"
                                class="form-label"
                            >Keterangan</label>
                            <textarea
                                class="form-control @error('keterangan') is-invalid @enderror"
                                id="keterangan"
                                name="keterangan"
                                rows="3"
                            >{{ old('keterangan', $payment->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a
                                href="{{ route('payments.show', $payment->siswa_id) }}"
                                class="btn btn-outline-secondary"
                            >Batal</a>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/payments-edit.css') }}"
    >
@endpush
