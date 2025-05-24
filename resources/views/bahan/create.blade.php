@extends('partials.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Pengambilan Bahan</h3>
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ route('bahan.store') }}"
                            method="POST"
                        >
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
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
                                            {{ request('siswa_id') ? 'disabled' : '' }}
                                        >
                                            <option value="">Pilih Siswa</option>
                                            @foreach ($siswas as $siswa)
                                                <option
                                                    value="{{ $siswa->id }}"
                                                    {{ old('siswa_id', request('siswa_id')) == $siswa->id ? 'selected' : '' }}
                                                >
                                                    {{ $siswa->namasiswa }} - {{ $siswa->nisn }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if (request('siswa_id'))
                                            <input
                                                type="hidden"
                                                name="siswa_id"
                                                value="{{ request('siswa_id') }}"
                                            >
                                        @endif
                                        @error('siswa_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label
                                            for="nama_bahan"
                                            class="form-label"
                                        >Nama Bahan</label>
                                        <input
                                            type="text"
                                            class="form-control @error('nama_bahan') is-invalid @enderror"
                                            id="nama_bahan"
                                            name="nama_bahan"
                                            value="Bahan Osis, Pramuka, Atribut, dasi, topi, badge"
                                            required
                                        >
                                        @error('nama_bahan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label
                                            for="jumlah"
                                            class="form-label"
                                        >Jumlah</label>
                                        <input
                                            type="number"
                                            class="form-control @error('jumlah') is-invalid @enderror"
                                            id="jumlah"
                                            name="jumlah"
                                            value="1"
                                            required
                                            min="1"
                                        >
                                        @error('jumlah')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label
                                            for="tanggal_pengambilan"
                                            class="form-label"
                                        >Tanggal Pengambilan</label>
                                        <input
                                            type="date"
                                            class="form-control @error('tanggal_pengambilan') is-invalid @enderror"
                                            id="tanggal_pengambilan"
                                            name="tanggal_pengambilan"
                                            value="{{ old('tanggal_pengambilan', date('Y-m-d')) }}"
                                            required
                                        >
                                        @error('tanggal_pengambilan')
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
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >Simpan</button>
                                    <a
                                        href="{{ route('bahan.index') }}"
                                        class="btn btn-secondary"
                                    >Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
