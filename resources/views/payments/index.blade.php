@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Pembayaran Siswa</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="bg-primary text-white">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Jurusan</th>
                                        <th>Total Pembayaran</th>
                                        <th width="200px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($siswas as $index => $siswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->namasiswa }}</td>
                                            <td>{{ $siswa->jurusan }}</td>
                                            <td>
                                                Rp {{ number_format($siswa->pembayarans->sum('nominal'), 0, ',', '.') }}
                                            </td>
                                            <td>
                                                <div
                                                    class="btn-group"
                                                    role="group"
                                                >
                                                    <a
                                                        href="{{ route('payments.create', ['siswa_id' => $siswa->id]) }}"
                                                        class="btn btn-success btn-sm"
                                                    >
                                                        <i class="bi bi-plus-circle"></i> Tambah Pembayaran
                                                    </a>
                                                    <a
                                                        href="{{ route('payments.show', $siswa->id) }}"
                                                        class="btn btn-info btn-sm ms-1"
                                                    >
                                                        <i class="bi bi-eye"></i> Detail
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="5"
                                                class="text-center"
                                            >Tidak ada data siswa</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
