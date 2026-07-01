@extends('partials.master')

@section('indexbayar')
    <main class="app-main py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-lg mb-4">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h5 class="card-title m-0 text-primary">Riwayat Pembayaran</h5>
                                    <p class="text-muted small mb-0 mt-1">{{ $siswa->namasiswa }}</p>
                                </div>
                                <div class="mt-2 mt-sm-0">
                                    <a
                                        href="{{ route('payments.create', ['siswa_id' => $siswa->id]) }}"
                                        class="btn btn-primary"
                                    >
                                        <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @if ($siswa->pembayarans->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th
                                                    class="text-center"
                                                    width="50"
                                                >#</th>
                                                <th>Kode</th>
                                                <th>Nama Pembayaran</th>
                                                <th class="text-end">Nominal</th>
                                                <th>Penerima</th>
                                                <th>Tanggal</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($siswa->pembayarans as $index => $bayar)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td><span
                                                            class="badge bg-light text-dark">{{ $bayar->kode_bayar }}</span>
                                                    </td>
                                                    <td>{{ $bayar->nama_pembayaran }}</td>
                                                    <td class="text-end fw-bold">
                                                        @if ($bayar->nominal < 0)
                                                            <span class="text-danger">
                                                                -Rp{{ number_format(abs($bayar->nominal), 0, ',', '.') }}
                                                            </span>
                                                        @else
                                                            <span class="text-success">
                                                                Rp{{ number_format($bayar->nominal, 0, ',', '.') }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $bayar->keterangan ?? '-' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($bayar->tanggal_bayar)->format('d M Y') }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-1">
                                                            @if ($bayar->nominal < 0)
                                                                <a
                                                                    href="{{ route('payments.print.kwitansi-kembalian', $bayar->id) }}"
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    target="_blank"
                                                                    title="Cetak Kwitansi Pengembalian"
                                                                >
                                                                    <i class="bi bi-receipt"></i>
                                                                    <strong>Kembalian</strong>
                                                                </a>
                                                            @else
                                                                <a
                                                                    href="{{ route('payments.print.kwitansi', $bayar->id) }}"
                                                                    class="btn btn-sm btn-outline-success"
                                                                    target="_blank"
                                                                    title="Cetak Kwitansi"
                                                                >
                                                                    <i class="bi bi-receipt"></i>
                                                                    <strong>Kwitansi</strong>
                                                                </a>
                                                            @endif

                                                            @if (auth()->user()->isAdmin())
                                                                <a
                                                                    href="{{ route('payments.edit', $bayar->id) }}"
                                                                    class="btn btn-sm btn-outline-primary"
                                                                    title="Edit Pembayaran"
                                                                >
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <form
                                                                    action="{{ route('payments.destroy', $bayar->id) }}"
                                                                    method="POST"
                                                                    class="d-inline"
                                                                    onsubmit="return confirm('Yakin ingin menghapus pembayaran ini?')"
                                                                >
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        type="submit"
                                                                        class="btn btn-sm btn-outline-danger"
                                                                        title="Hapus Pembayaran"
                                                                    >
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-3 bg-light">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <span class="text-muted">Total Pembayaran:</span>
                                        </div>
                                        <div>
                                            <span
                                                class="fs-5 fw-bold text-primary">Rp{{ number_format($siswa->pembayarans->sum('nominal'), 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-center p-5">
                                    <div class="mb-3">
                                        <i
                                            class="bi bi-info-circle text-muted"
                                            style="font-size: 3rem;"
                                        ></i>
                                    </div>
                                    <h6 class="text-muted">Belum ada riwayat pembayaran untuk siswa ini.</h6>
                                    <div class="mt-4">
                                        <a
                                            href="{{ route('payments.create', ['siswa_id' => $siswa->id]) }}"
                                            class="btn btn-outline-primary"
                                        >
                                            <i class="bi bi-plus-circle me-1"></i> Tambah Pembayaran Pertama
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <a
                            href="{{ route('payments.index') }}"
                            class="btn btn-outline-secondary"
                        >
                            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
