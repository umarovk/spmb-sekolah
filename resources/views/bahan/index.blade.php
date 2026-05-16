@extends('partials.master')

@section('content')

    <div class="dashboard-content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">


                {{-- CARD --}}
                <div class="card">

                    {{-- CARD HEADER --}}
                    <div class="card-header">
                        {{-- JUDUL  PENGAMBILAN DAN EXPORT DATA --}}
                        <div class="container py-4">
                            <div class="row mb-4 align-items-center">
                                <div class="col-md-8">
                                    <h1 class="fw-light text-primary mb-0 fs-3">Data Pengambilan Bahan Siswa</h1>
                                </div>
                                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                    <a
                                        href="{{ route('bahan.export') }}"
                                        class="btn btn-success w-50"
                                    >
                                        Download Data <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CARD BODY --}}
                    <div class="card-body">
                        <!-- Form Pencarian -->
                        <form
                            action="{{ route('bahan.index') }}"
                            method="GET"
                            class="mb-4"
                        >
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input
                                            type="text"
                                            name="search"
                                            class="form-control"
                                            placeholder="Cari nama..."
                                            value="{{ $search }}"
                                        >
                                        <button
                                            class="btn btn-outline-secondary"
                                            type="submit"
                                        >
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select
                                        name="status"
                                        class="form-select"
                                        onchange="this.form.submit()"
                                    >
                                        <option value="">Semua Data</option>
                                        <option
                                            value="diberikan"
                                            {{ $status === 'diberikan' ? 'selected' : '' }}
                                        >Diberikan</option>
                                        <option
                                            value="belum_ambil"
                                            {{ $status === 'belum_ambil' ? 'selected' : '' }}
                                        >Belum Ambil Bahan</option>
                                    </select>
                                </div>

                                @if ($search || $status)
                                    <div class="col-md-2">
                                        <a
                                            href="{{ route('bahan.index') }}"
                                            class="btn btn-secondary"
                                        >
                                            <i class="bi bi-x-circle"></i> Reset
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>

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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Jurusan</th>
                                        <th>Status Pengambilan</th>
                                        <th>Tanggal Pengambilan</th>
                                        <th>Detail Pengambilan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswas as $index => $siswa)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $siswa->namasiswa }}</td>
                                            <td>{{ $siswa->jurusan }}</td>
                                            <td>
                                                @if ($siswa->pengambilanBahans->isNotEmpty())
                                                    <span
                                                        class="badge bg-{{ $siswa->pengambilanBahans->first()->status === 'diberikan' ? 'success' : 'warning' }}"
                                                    >
                                                        {{ $siswa->pengambilanBahans->first()->status }}
                                                    </span>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($siswa->pengambilanBahans->isNotEmpty())
                                                    {{ $siswa->pengambilanBahans->first()->tanggal_pengambilan->format('d/m/Y') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($siswa->pengambilanBahans->isNotEmpty())
                                                    <button
                                                        type="button"
                                                        class="btn btn-info btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $siswa->id }}"
                                                    >
                                                        <i class="bi bi-eye"></i> Lihat Detail
                                                    </button>

                                                    <!-- Modal Detail -->
                                                    <div
                                                        class="modal fade"
                                                        id="detailModal{{ $siswa->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="detailModalLabel{{ $siswa->id }}"
                                                        aria-hidden="true"
                                                    >
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5
                                                                        class="modal-title"
                                                                        id="detailModalLabel{{ $siswa->id }}"
                                                                    >Detail Pengambilan Bahan - {{ $siswa->namasiswa }}
                                                                    </h5>
                                                                    <button
                                                                        type="button"
                                                                        class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"
                                                                    ></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-sm">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Tanggal</th>
                                                                                <th>Bahan</th>
                                                                                <th>Jumlah</th>
                                                                                <th>Keterangan</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($siswa->pengambilanBahans as $bahan)
                                                                                <tr>
                                                                                    <td>{{ $bahan->tanggal_pengambilan->format('d/m/Y') }}
                                                                                    </td>
                                                                                    <td>{{ $bahan->nama_bahan }}</td>
                                                                                    <td>{{ $bahan->jumlah }}</td>
                                                                                    <td>{{ $bahan->keterangan ?? '-' }}
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($siswa->pengambilanBahans->isEmpty())
                                                    <a
                                                        href="{{ route('bahan.create', ['siswa_id' => $siswa->id]) }}"
                                                        class="btn btn-primary btn-sm"
                                                    >
                                                        <i class="bi bi-plus"></i> Ambil Bahan
                                                    </a>
                                                @else
                                                    <div
                                                        class="btn-group"
                                                        role="group"
                                                    >
                                                        <a
                                                            href="{{ route('bahan.ubah', $siswa->pengambilanBahans->first()) }}"
                                                            class="btn btn-warning btn-sm"
                                                        >
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <form
                                                            action="{{ route('bahan.destroy', $siswa->pengambilanBahans->first()) }}"
                                                            method="POST"
                                                            class="d-inline"
                                                        >
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                                            >
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="7"
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
        </div>
    </div>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/bahan.css') }}"
    >
@endpush

@push('scripts')
    <script src="{{ asset('js/bahan.js') }}"></script>
@endpush
