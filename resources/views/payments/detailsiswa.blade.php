@extends('partials.master')

@section('content')

    <div class="container">
        <h1>Data Siswa</h1>
        <table>
            <tr>
                <th>Nama</th>
                <td>{{ $siswa->namasiswa }}</td>
            </tr>
            <tr>
                <th>NIS</th>
                <td>{{ $siswa->nis }}</td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td>{{ $siswa->jurusan }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $siswa->jeniskelamin }}</td>
            </tr>
        </table>

        <h2>Riwayat Pembayaran</h2>
        @if ($riwayatPembayaran->isEmpty())
            <p>Tidak ada riwayat pembayaran untuk siswa ini.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Kode Bayar</th>
                        <th>Nama Pembayaran</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Tanggal Bayar</th>
                        <th>Teller</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPembayaran as $pembayaran)
                        <tr>
                            <td>{{ $pembayaran->kode_bayar }}</td>
                            <td>{{ $pembayaran->nama_pembayaran }}</td>
                            <td>Rp {{ number_format($pembayaran->nominal, 0, ',', '.') }}</td>
                            <td>{{ $pembayaran->keterangan }}</td>
                            <td>{{ $pembayaran->tanggal_bayar }}</td>
                            <td>{{ $pembayaran->teller }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
