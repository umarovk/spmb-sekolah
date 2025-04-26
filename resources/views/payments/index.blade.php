@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <h3 class="card-title">Data Pembayaran Siswa</h3>
                            </div>
                            <div class="col-md-4">
                                <form
                                    action="{{ route('payments.index') }}"
                                    method="GET"
                                    class="float-end"
                                >
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            name="search"
                                            class="form-control form-control-sm"
                                            placeholder="Cari nama siswa..."
                                            value="{{ $search ?? '' }}"
                                        >
                                        <button
                                            class="btn btn-primary btn-sm"
                                            type="submit"
                                        >
                                            <i class="bi bi-search"></i>
                                        </button>
                                        @if ($search)
                                            <a
                                                href="{{ route('payments.index') }}"
                                                class="btn btn-secondary btn-sm"
                                            >
                                                <i class="bi bi-x-circle"></i>
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Tampilkan alert jika tidak ada hasil pencarian -->
                        @if ($search && $siswas->isEmpty())
                            <div class="alert alert-info">
                                Tidak ditemukan siswa dengan nama yang mengandung "{{ $search }}"
                            </div>
                        @endif

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
