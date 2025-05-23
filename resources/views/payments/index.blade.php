@extends('partials.master')

@section('content')
    <main class="app-main bg-light">
        <div class="container py-4">
            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-light text-primary mb-0 fs-3">Data Pembayaran Siswa</h1>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <!-- Add any global action button here if needed -->
                    <a
                        href="{{ route('payments.export') }}"
                        class="btn btn-success w-50"
                    >
                        Download Data <i class="bi bi-download"></i>
                    </a>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-6 mb-3 mb-md-0">
                            <form
                                action="{{ route('payments.index') }}"
                                method="GET"
                            >
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                name="search"
                                                class="form-control border-end-0"
                                                placeholder="Cari nama siswa..."
                                                value="{{ $search ?? '' }}"
                                                aria-label="Cari nama siswa"
                                            >
                                            <button
                                                class="btn btn-outline-secondary border-start-0 bg-white"
                                                type="submit"
                                            >
                                                <i class="bi bi-search text-muted"></i>
                                            </button>
                                            @if ($search || $status)
                                                <a
                                                    href="{{ route('payments.index') }}"
                                                    class="btn btn-outline-secondary"
                                                >
                                                    <i class="bi bi-x-lg"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <select
                                            name="status"
                                            class="form-select"
                                            onchange="this.form.submit()"
                                        >
                                            <option value="">Semua Data</option>
                                            <option
                                                value="sudah_bayar"
                                                {{ $status === 'sudah_bayar' ? 'selected' : '' }}
                                            >
                                                Sudah Bayar
                                            </option>
                                            <option
                                                value="belum_bayar"
                                                {{ $status === 'belum_bayar' ? 'selected' : '' }}
                                            >
                                                Belum Bayar
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Alert for no search results -->
                @if ($search && $siswas->isEmpty())
                    <div
                        class="alert alert-info m-3 mb-0 d-flex align-items-center border-0 rounded-3 bg-info bg-opacity-10"
                        role="alert"
                    >
                        <i class="bi bi-info-circle me-2 text-info fs-5"></i>
                        <div>
                            Tidak ditemukan siswa dengan nama yang mengandung "<strong>{{ $search }}</strong>"
                        </div>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama Siswa</th>
                                <th>Jurusan</th>
                                <th>Total Pembayaran</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswas as $index => $siswa)
                                <tr>
                                    <td class="ps-3">{{ $index + 1 }}</td>
                                    <td>
                                        <span class="fw-medium">{{ $siswa->namasiswa }}</span>
                                    </td>
                                    <td>{{ $siswa->jurusan }}</td>
                                    <td>
                                        <span class="fw-medium text-success">
                                            Rp {{ number_format($siswa->pembayarans->sum('nominal'), 0, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2 pe-3">
                                            <a
                                                href="{{ route('payments.create', ['siswa_id' => $siswa->id]) }}"
                                                class="btn btn-sm btn-outline-success rounded-pill"
                                                title="Tambah Pembayaran"
                                            >
                                                <i class="bi bi-plus-circle me-1"></i>
                                                <span class="d-none d-lg-inline">Pembayaran</span>
                                            </a>
                                            <a
                                                href="{{ route('payments.show', $siswa->id) }}"
                                                class="btn btn-sm btn-outline-info rounded-pill"
                                                title="Lihat Detail"
                                            >
                                                <i class="bi bi-eye me-1"></i>
                                                <span class="d-none d-lg-inline">Detail</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="text-center py-4 text-muted"
                                    >
                                        <i class="bi bi-credit-card fs-4 d-block mb-2"></i>
                                        Tidak ada data siswa
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-top border-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-muted small mb-0">
                            {{ $siswas->count() }} siswa ditemukan
                        </p>

                        <!-- If pagination is implemented, render it here -->
                        @if (isset($siswas) && method_exists($siswas, 'links'))
                            <div>
                                {{ $siswas->appends(['search' => $search ?? ''])->links('vendor.pagination.custom') }}
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/payments.css') }}"
    >
@endpush

@push('scripts')
    <script src="{{ asset('js/payments.js') }}"></script>
@endpush
