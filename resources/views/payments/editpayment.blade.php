@extends('partials.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Edit Pembayaran</h4>
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
                    action="{{ route('payments.update', $payment->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

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
                                    {{ old('siswa_id', $payment->siswa_id) == $siswa->id ? 'selected' : '' }}
                                >
                                    {{ $siswa->nama }} - {{ $siswa->nis ?? 'NIS tidak tersedia' }}
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label
                            for="kode_bayar"
                            class="form-label"
                        >Kode Pembayaran</label>
                        <input
                            type="text"
                            class="form-control"
                            id="kode_bayar"
                            value="{{ $payment->kode_bayar }}"
                            readonly
                            disabled
                        >
                        <small class="text-muted">Kode pembayaran tidak dapat diubah</small>
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
                            value="{{ old('nama_pembayaran', $payment->nama_pembayaran) }}"
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
                                value="{{ old('nominal', $payment->nominal) }}"
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
                            value="{{ old('tanggal_bayar', $payment->tanggal_bayar->format('Y-m-d')) }}"
                            required
                        >
                        @error('tanggal_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
                            value="{{ old('teller', $payment->teller) }}"
                        >
                        @error('teller')
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

                    <div class="d-flex justify-content-between">
                        <a
                            href="{{ route('payments.show', $payment->id) }}"
                            class="btn btn-secondary"
                        >Batal</a>
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >Update Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
