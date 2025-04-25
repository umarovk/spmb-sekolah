@extends('partials.master')

@section('content')
    <div class="container">
        <h3>Tambah Pembayaran untuk {{ $siswa->nama }}</h3>

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
                <label>Nama Pembayaran</label>
                <input
                    type="text"
                    name="nama_pembayaran"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Nominal</label>
                <input
                    type="number"
                    name="nominal"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Tanggal Bayar</label>
                <input
                    type="date"
                    name="tanggal_bayar"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea
                    name="keterangan"
                    class="form-control"
                ></textarea>
            </div>

            <div class="mb-3">
                <label>Teller</label>
                <input
                    type="text"
                    name="teller"
                    class="form-control"
                >
            </div>

            <button
                type="submit"
                class="btn btn-primary"
            >Simpan</button>
        </form>
    </div>
@endsection
