@extends('partials.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Detail Pembayaran</h4>
                <div>
                    <a
                        href="{{ route('payments.edit', $payment->id) }}"
                        class="btn btn-warning"
                    >Edit</a>
                    <a
                        href="{{ route('payments.index') }}"
                        class="btn btn-secondary"
                    >Kembali</a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="30%">Kode Pembayaran</th>
                                <td>{{ $payment->kode_bayar }}</td>
                            </tr>
                            <tr>
                                <th>Nama Siswa</th>
                                <td>
                                    <a href="{{ route('payments.by.siswa', $payment->siswa_id) }}">
                                        {{ $payment->siswa->namasiswa ?? 'Data siswa tidak ditemukan' }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td>{{ $payment->siswa->nis ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Pembayaran</th>
                                <td>{{ $payment->nama_pembayaran }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th width="30%">Nominal</th>
                                <td>Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Bayar</th>
                                <td>{{ $payment->tanggal_bayar->format('d/m/Y') }}</td>
                            </tr>
                            <tr>
                                <th>Petugas</th>
                                <td>{{ $payment->teller }}</td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $payment->keterangan ?: '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="mt-4">
                    <h5>Tindakan</h5>
                    <div class="btn-group">
                        <a
                            href="#"
                            class="btn btn-primary"
                            onclick="window.print()"
                        >Cetak Kuitansi</a>
                        <form
                            action="{{ route('payments.destroy', $payment->id) }}"
                            method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pembayaran ini?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn btn-danger ms-2"
                            >Hapus Pembayaran</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
