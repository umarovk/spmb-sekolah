@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Pembayaran - {{ $siswa->namasiswa }}</h3>
                    </div>
                    <div class="card-body">
                        @if ($siswa->pembayarans->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Bayar</th>
                                        <th>Nama Pembayaran</th>
                                        <th>Nominal</th>
                                        <th>Penerima</th>
                                        <th>Tanggal Bayar</th>
                                        {{-- <th>Teller</th> --}}
                                        <th>Print</th>
                                    </tr>
                                    <tbody>
                                        @foreach ($siswa->pembayarans as $index => $bayar)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $bayar->kode_bayar }}</td>
                                                <td>{{ $bayar->nama_pembayaran }}</td>
                                                <td>Rp{{ number_format($bayar->nominal, 0, ',', '.') }}</td>
                                                <td>{{ $bayar->keterangan ?? '-' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}
                                                </td>
                                                {{-- <td>{{ $bayar->teller }}</td> --}}
                                                <td>
                                                    <a
                                                        href="{{ route('payments.print.kwitansi', $bayar->id) }}"
                                                        class="btn btn-outline-primary btn-sm"
                                                        target="_blank"
                                                        title="Cetak Kwitansi"
                                                    >
                                                        <i class="bi bi-receipt"></i>
                                                        <span class="ms-1">Cetak</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-light">
                                            <td
                                                colspan="3"
                                                class="text-end"
                                            ><strong>Total Pembayaran:</strong></td>
                                            <td colspan="4">
                                                <strong>Rp{{ number_format($siswa->pembayarans->sum('nominal'), 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Belum ada riwayat pembayaran untuk siswa ini.
                            </div>
                        @endif
                    </div>

                </div>
                <div class="mt-3">
                    <a
                        href="{{ route('payments.index') }}"
                        class="btn btn-secondary"
                    >
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a
                        href="{{ route('payments.create', ['siswa_id' => $siswa->id]) }}"
                        class="btn btn-success"
                    >
                        <i class="bi bi-plus-circle"></i> Tambah Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
