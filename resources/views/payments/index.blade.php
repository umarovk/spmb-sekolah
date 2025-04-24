@extends('partials.master')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Daftar Pembayaran</h4>
                <a
                    href="{{ route('payments.create') }}"
                    class="btn btn-primary"
                >Tambah Pembayaran</a>
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
                                <th>Kode Bayar</th>
                                <th>Nama Siswa</th>
                                <th>Pembayaran</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
                                <th>Teller</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>{{ $payment->kode_bayar }}</td>
                                    <td>
                                        <a href="{{ route('payments.by.siswa', $payment->siswa_id) }}">
                                            {{ $payment->siswa->nama ?? 'Data siswa tidak ditemukan' }}
                                        </a>
                                    </td>
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
                                    >Tidak ada data pembayaran</td>
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
