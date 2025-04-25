@extends('partials.master')

@section('content')
    <div class="container">
        <h3>Riwayat Pembayaran - {{ $payment->nama }} ({{ $payment->nis }})</h3>

        @if ($payment->pembayaran->count() > 0)
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Bayar</th>
                        <th>Nama Pembayaran</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Tanggal Bayar</th>
                        <th>Teller</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payment->pembayaran as $index => $bayar)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $bayar->kode_bayar }}</td>
                            <td>{{ $bayar->nama_pembayaran }}</td>
                            <td>Rp{{ number_format($bayar->nominal, 0, ',', '.') }}</td>
                            <td>{{ $bayar->keterangan ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}</td>
                            <td>{{ $bayar->teller }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="alert alert-info mt-3">Belum ada riwayat pembayaran untuk siswa ini.</p>
        @endif

        <div class="mt-2">
            <strong>Total Bayar: </strong> Rp{{ number_format($siswa->pembayaran->sum('nominal'), 0, ',', '.') }}
        </div>

        <a
            href="{{ route('siswa.index') }}"
            class="btn btn-secondary mt-3"
        >Kembali ke Data Siswa</a>
    </div>
@endsection
