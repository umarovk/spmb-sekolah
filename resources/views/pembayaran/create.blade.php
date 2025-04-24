@extends('partials.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tambah Pembayaran Baru</div>

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
                            enctype="multipart/form-data"
                        >
                            @csrf

                            <div class="mb-3">
                                <label
                                    for="siswa_id"
                                    class="form-label"
                                >Pilih Siswa</label>
                                <select
                                    class="form-select @error('siswa_id') is-invalid @enderror"
                                    id="siswa_id"
                                    name="siswa_id"
                                    required
                                >
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswas as $siswa)
                                        <option
                                            value="{{ $siswa->id }}"
                                            {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}
                                        >
                                            {{ $siswa->nama }} ({{ $siswa->nik ?? 'NIK tidak tersedia' }})
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
                                >Nama Pembayaran</label>
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
                                    for="jumlah"
                                    class="form-label"
                                >Jumlah (Rp)</label>
                                <input
                                    type="number"
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah"
                                    name="jumlah"
                                    value="{{ old('jumlah') }}"
                                    required
                                >
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label
                                    for="tanggal_pembayaran"
                                    class="form-label"
                                >Tanggal Pembayaran</label>
                                <input
                                    type="date"
                                    class="form-control @error('tanggal_pembayaran') is-invalid @enderror"
                                    id="tanggal_pembayaran"
                                    name="tanggal_pembayaran"
                                    value="{{ old('tanggal_pembayaran', date('Y-m-d')) }}"
                                    required
                                >
                                @error('tanggal_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label
                                    for="metode_pembayaran"
                                    class="form-label"
                                >Metode Pembayaran</label>
                                <select
                                    class="form-select @error('metode_pembayaran') is-invalid @enderror"
                                    id="metode_pembayaran"
                                    name="metode_pembayaran"
                                    required
                                >
                                    <option value="">Pilih Metode</option>
                                    <option
                                        value="Tunai"
                                        {{ old('metode_pembayaran') == 'Tunai' ? 'selected' : '' }}
                                    >Tunai</option>
                                    <option
                                        value="Transfer Bank"
                                        {{ old('metode_pembayaran') == 'Transfer Bank' ? 'selected' : '' }}
                                    >Transfer Bank</option>
                                    <option
                                        value="QRIS"
                                        {{ old('metode_pembayaran') == 'QRIS' ? 'selected' : '' }}
                                    >QRIS</option>
                                    <option
                                        value="Lainnya"
                                        {{ old('metode_pembayaran') == 'Lainnya' ? 'selected' : '' }}
                                    >Lainnya</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label
                                    for="status_pembayaran"
                                    class="form-label"
                                >Status Pembayaran</label>
                                <select
                                    class="form-select @error('status_pembayaran') is-invalid @enderror"
                                    id="status_pembayaran"
                                    name="status_pembayaran"
                                    required
                                >
                                    <option value="">Pilih Status</option>
                                    <option
                                        value="Lunas"
                                        {{ old('status_pembayaran') == 'Lunas' ? 'selected' : '' }}
                                    >Lunas</option>
                                    <option
                                        value="Belum Lunas"
                                        {{ old('status_pembayaran') == 'Belum Lunas' ? 'selected' : '' }}
                                    >Belum Lunas</option>
                                    <option
                                        value="Cicilan"
                                        {{ old('status_pembayaran') == 'Cicilan' ? 'selected' : '' }}
                                    >Cicilan</option>
                                </select>
                                @error('status_pembayaran')
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

                            <div class="mb-3">
                                <label
                                    for="bukti_pembayaran"
                                    class="form-label"
                                >Bukti Pembayaran</label>
                                <input
                                    type="file"
                                    class="form-control @error('bukti_pembayaran') is-invalid @enderror"
                                    id="bukti_pembayaran"
                                    name="bukti_pembayaran"
                                >
                                <small class="text-muted">Format: JPG, PNG, PDF. Maks: 2MB</small>
                                @error('bukti_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a
                                    href="{{ route('payments.index') }}"
                                    class="btn btn-secondary me-md-2"
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
        </div>
    </div>
@endsection
