@extends('partials.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Daftar Pembayaran</span>
                    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary btn-sm">Tambah Pembayaran</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Nama Pembayaran</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                    <th>Metode</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayarans as $index => $pembayaran)
                                <tr>
                                    <td>{{ $index + $pembayarans->firstItem() }}</td>
                                    <td>{{ $pembayaran->siswa->nama }}</td>
                                    <td>{{ $pembayaran->nama_pembayaran }}</td>
                                    <td>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d-m-Y') }}</td>
                                    <td>{{ $pembayaran->metode_pembayaran }}</td>
                                    <td>
                                        <span class="badge bg-{{ $pembayaran->status_pembayaran == 'Lunas' ? 'success' : 'warning' }}">
                                            {{ $pembayaran->status_pembayaran }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pembayaran.show', $pembayaran->id) }}" class="btn btn-info btn-sm">Detail</a>
                                            <a href="{{ route('pembayaran.edit', $pembayaran->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('pembayaran.destroy', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data pembayaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $pembayarans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection