@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h1>Data Pembayaran Siswa</h1>
                <div class="card card-info card-outline mb-4">

                    <form
                        method="GET"
                        action="{{ route('siswa.index') }}"
                        class="mb-3"
                    >
                        <div class="card-body">
                            <div class="row g-3">

                                <div class="input-group">
                                    <input
                                        type="text"
                                        name="search"
                                        class="form-control"
                                        placeholder="Cari nama / NIS siswa..."
                                    >
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >Cari</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card-body">
                        <div class="row g-3">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Jenis Kelamin</th>
                                        <th>NIS</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswa as $item)
                                        <tr>
                                            <td>{{ $item->namasiswa }}</td>
                                            <td>{{ $item->jurusan }}</td>
                                            <td>{{ $item->jeniskelamin }}</td>
                                            <td>{{ $item->nis }}</td>
                                            <td>
                                                <a
                                                    href="{{ route('payments.create', ['siswa_id' => $item->id]) }}"
                                                    class="btn btn-sm btn-success"
                                                >
                                                    Tambah Pembayaran
                                                </a>
                                                <a
                                                    href="{{ route('payments.detailsiswa', ['siswa_id' => $item->id]) }}"
                                                    class="btn btn-sm btn-success"
                                                >
                                                    Detail Pembayaran
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="5"
                                                class="text-center"
                                            >Tidak ada data siswa.</td>
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
