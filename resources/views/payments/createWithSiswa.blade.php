@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Tambah Pembayaran untuk {{ $selectedSiswa->nama }}</h4>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card mb-4 bg-light">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Siswa</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Nama</th>
                                        <td>: {{ $selectedSiswa->nama }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIS</th>
                                        <td>: {{ $selectedSiswa->nis ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="30%">Kelas</th>
                                        <td>: {{ $selectedSiswa->kelas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>: {{ $selectedSiswa->alamat ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <form
                    action="{{ route('payments.store') }}"
                    method="POST"
                >
                    @csrf

                    <!-- Hidden input for siswa_id -->
                    <input
                        type="hidden"
                        name="siswa_id"
                        value="{{ $selectedSiswa->id }}"
                    >

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="kode_bayar"
                                    class="form-label"
                                >Kode Pembayaran</label>
                                <input
                                    type="text"
                                    class="form-control @error('kode_bayar') is-invalid @enderror"
                                    id="kode_bayar"
                                    name="kode_bayar"
                                    value="{{ old('kode_bayar', $kodeBayar ?? '') }}"
                                    {{ isset($kodeBayar) ? 'readonly' : '' }}
                                >
                                <small class="form-text text-muted">Kode akan dibuat otomatis jika dibiarkan kosong</small>
                                @error('kode_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="tanggal_bayar"
                                    class="form-label"
                                >Tanggal Bayar</label>
                                <input
                                    type="date"
                                    class="form-control @error('tanggal_bayar') is-invalid @enderror"
                                    id="tanggal_bayar"
                                    name="tanggal_bayar"
                                    value="{{ old('tanggal_bayar', date('Y-m-d')) }}"
                                    required
                                >
                                @error('tanggal_bayar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="nama_pembayaran"
                                    class="form-label"
                                >Jenis Pembayaran</label>
                                <input
                                    type="text"
                                    class="form-control @error('nama_pembayaran') is-invalid @enderror"
                                    id="nama_pembayaran"
                                    name="nama_pembayaran"
                                    value="{{ old('nama_pembayaran') }}"
                                    required
                                >
                                @error('nama_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="nominal"
                                    class="form-label"
                                >Nominal</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input
                                        type="number"
                                        class="form-control @error('nominal') is-invalid @enderror"
                                        id="nominal"
                                        name="nominal"
                                        value="{{ old('nominal') }}"
                                        required
                                    >
                                </div>
                                @error('nominal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label
                                    for="teller"
                                    class="form-label"
                                >Petugas</label>
                                <input
                                    type="text"
                                    class="form-control @error('teller') is-invalid @enderror"
                                    id="teller"
                                    name="teller"
                                    value="{{ old('teller', Auth::user()->name ?? '') }}"
                                >
                                @error('teller')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                        >{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a
                            href="{{ route('payments.by.siswa', $selectedSiswa->id) }}"
                            class="btn btn-secondary"
                        >Kembali</a>
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >Simpan Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
