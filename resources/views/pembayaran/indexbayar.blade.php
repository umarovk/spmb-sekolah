@extends('partials.master')

@section('indexbayar')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Pembayaran</h5>
                        <a
                            href="{{ route('payments.create') }}"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-plus"></i> Tambah Pembayaran
                        </a>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div
                                class="alert alert-success alert-dismissible fade show"
                                role="alert"
                            >
                                {{ session('success') }}
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"
                                ></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-striped"
                                id="tabelPembayaran"
                            >
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($pembayaran as $index => $bayar) --}}
                                    @foreach ($datapembayaran as $bayar)
                                        <tr>
                                            <td>{{ $bayar->siswa->nama }}</td>
                                            <td>{{ $bayar->siswa->nama }}</td>
                                            <td>{{ $bayar->siswa->nama }}</td>
                                            <td>{{ $bayar->siswa->nama }}</td>
                                            <td>Rp {{ number_format($bayar->jumlah, 0, ',', '.') }}</td>
                                            <td>{{ date('d-m-Y', strtotime($bayar->tanggal_pembayaran)) }}</td>
                                            <td>
                                                @if ($bayar->status_pembayaran == 'Lunas')
                                                    <span class="badge bg-success">{{ $bayar->status_pembayaran }}</span>
                                                @elseif ($bayar->status_pembayaran == 'Pending')
                                                    <span class="badge bg-warning">{{ $bayar->status_pembayaran }}</span>
                                                @elseif ($bayar->status_pembayaran == 'Belum Lunas')
                                                    <span class="badge bg-danger">{{ $bayar->status_pembayaran }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $bayar->status_pembayaran }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div
                                                    class="btn-group"
                                                    role="group"
                                                >
                                                    <a
                                                        href="{{ route('pembayaran.by.siswa', $bayar->id) }}"
                                                        class="btn btn-sm btn-info"
                                                    >
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a
                                                        href="{{ route('pembayaran.edit', $bayar->id) }}"
                                                        class="btn btn-sm btn-warning"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $bayar->id }}"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>

                                                <!-- Modal Hapus -->
                                                <div
                                                    class="modal fade"
                                                    id="deleteModal{{ $bayar->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="deleteModalLabel"
                                                    aria-hidden="true"
                                                >
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5
                                                                    class="modal-title"
                                                                    id="deleteModalLabel"
                                                                >Konfirmasi Hapus</h5>
                                                                <button
                                                                    type="button"
                                                                    class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"
                                                                ></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apakah Anda yakin ingin menghapus data pembayaran
                                                                <strong>{{ $bayar->jenis_pembayaran }}</strong>
                                                                untuk siswa
                                                                <strong>{{ $bayar->siswa->nama_lengkap }}</strong>?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-secondary"
                                                                    data-bs-dismiss="modal"
                                                                >Batal</button>
                                                                <form
                                                                    action="{{ route('pembayaran.destroy', $bayar->id) }}"
                                                                    method="POST"
                                                                >
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button
                                                                        type="submit"
                                                                        class="btn btn-danger"
                                                                    >Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        {{-- @empty --}}
                                        <tr>
                                            <td
                                                colspan="8"
                                                class="text-center"
                                            >Tidak ada data pembayaran</td>
                                        </tr>
                                    @endforeach
                                    {{-- @endforelse --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tabelPembayaran').DataTable({
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
                }
            });
        });
    </script>
@endsection
