@extends('partials.master')

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Informasi Siswa</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Nama Siswa</th>
                                <td>: {{ $siswa->nama }}</td>
                            </tr>
                            <tr>
                                <th>NIS</th>
                                <td>: {{ $siswa->nis ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Kelas</th>
                                <td>: {{ $siswa->kelas ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Total Pembayaran</th>
                                <td>: Rp {{ number_format($payments->sum('nominal'), 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Riwayat Pembayaran</h4>
                <div>
                    <a
                        href="{{ route('payments.create.with.siswa', $siswa->id) }}"
                        class="btn btn-primary"
                    >Tambah Pembayaran</a>
                    <a
                        href="{{ route('payments.index') }}"
                        class="btn btn-secondary"
                    >Kembali ke Daftar</a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Bayar</th>
                                <th>Pembayaran</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
                                <th>Teller</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $index => $payment)
                                <tr>
                                    <td>{{ $payments->firstItem() + $index }}</td>
                                    <td>{{ $payment->kode_bayar }}</td>
                                    <td>{{ $payment->nama_pembayaran }}</td>
                                    <td>Rp {{ number_format($payment->nominal, 0, ',', '.') }}</td>
                                    <td>{{ $payment->tanggal_bayar->format('d/m/Y') }}</td>
                                    <td>{{ $payment->teller }}</td>
                                    <td>
                                        <div
                                            class="btn-group"
                                            role="group"
                                        >
                                            <a
                                                href="{{ route('payments.show', $payment->id) }}"
                                                class="btn btn-sm btn-info"
                                            >
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a
                                                href="{{ route('payments.edit', $payment->id) }}"
                                                class="btn btn-sm btn-warning"
                                            >
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form
                                                action="{{ route('payments.destroy', $payment->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="btn btn-sm btn-danger"
                                                >
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="7"
                                        class="text-center"
                                    >Tidak ada data pembayaran untuk siswa ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $payments->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
