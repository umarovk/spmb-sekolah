@extends('partials.master')

@section('detailbayar')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Pembayaran</h5>
                    <div>
                        <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <h6 class="border-bottom pb-2 mb-3">Informasi Siswa</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>NIS:</strong> {{ $pembayaran->siswa->nis }}</p>
                            <p class="mb-1"><strong>Nama Lengkap:</strong> {{ $pembayaran->siswa->nama_lengkap }}</p>
                            <p class="mb-1"><strong>Kelas/Angkatan:</strong> {{ $pembayaran->siswa->tahun_masuk }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Jenis Kelamin:</strong> {{ $pembayaran->siswa->jenis_kelamin }}</p>
                            <p class="mb-1"><strong>Status:</strong> {{ $pembayaran->siswa->status }}</p>
                            <p class="mb-1"><strong>No. Telepon:</strong> {{ $pembayaran->siswa->no_telepon }}</p>
                        </div>
                    </div>

                    <h6 class="border-bottom pb-2 mb-3">Detail Pembayaran</h6>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-1"><strong>ID Pembayaran:</strong> #{{ $pembayaran->id }}</p>
                            <p class="mb-1"><strong>Jenis Pembayaran:</strong> {{ $pembayaran->jenis_pembayaran }}</p>
                            <p class="mb-1"><strong>Jumlah:</strong> Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</p>
                            <p class="mb-1"><strong>Tanggal Pembayaran:</strong> {{ date('d-m-Y', strtotime($pembayaran->tanggal_pembayaran)) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1"><strong>Metode Pembayaran:</strong> {{ $pembayaran->metode_pembayaran }}</p>
                            <p class="mb-1"><strong>Status Pembayaran:</strong> 
                                @if ($pembayaran->status_pembayaran == 'Lunas')
                                    <span class="badge bg-success">{{ $pembayaran->status_pembayaran }}</span>
                                @elseif ($pembayaran->status_pembayaran == 'Pending')
                                    <span class="badge bg-warning">{{ $pembayaran->status_pembayaran }}</span>
                                @elseif ($pembayaran->status_pembayaran == 'Belum Lunas')
                                    <span class="badge bg-danger">{{ $pembayaran->status_pembayaran }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $pembayaran->status_pembayaran }}</span>
                                @endif
                            </p>
                            <p class="mb-1"><strong>Tanggal Dibuat:</strong> {{ date('d-m-Y H:i', strtotime($pembayaran->created_at)) }}</p>
                            <p class="mb-1"><strong>Terakhir Diperbarui:</strong> {{ date('d-m-Y H:i', strtotime($pembayaran->updated_at)) }}</p>
                        </div>
                    </div>

                    @if ($pembayaran->keterangan)