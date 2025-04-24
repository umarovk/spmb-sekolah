@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h1>Input Pembayaran Siswa</h1>
                <div class="card card-info card-outline mb-4">

                    <div class="card-header">
                        <h4>Tambah Pembayaran Baru</h4>
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

                        <form
                            action="{{ route('payments.store') }}"
                            method="POST"
                        >
                            @csrf

                            <div class="mb-3">
                                <label
                                    for="siswa_id"
                                    class="form-label"
                                >Siswa</label>
                                <select
                                    name="siswa_id"
                                    id="siswa_id"
                                    class="form-select @error('siswa_id') is-invalid @enderror"
                                    required
                                >
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswaList as $siswa)
                                        <option
                                            value="{{ $siswa->id }}"
                                            {{ old('siswa_id') == $siswa->id || (isset($selectedSiswa) && $selectedSiswa->id == $siswa->id) ? 'selected' : '' }}
                                        >
                                            {{ $siswa->namasiswa }} - {{ $siswa->jurusan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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
                                    href="{{ route('payments.index') }}"
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
    </main>
@endsection
