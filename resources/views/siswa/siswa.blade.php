@extends('partials.master')

@section('isisiswa')
    <div class="dashboard-content">
        <div class="container-fluid py-4">
            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-light text-primary mb-0 fs-3">Data Calon Siswa Baru</h1>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button
                        class="btn btn-success rounded-pill shadow-sm"
                        onclick="window.location.href='{{ route('siswa.create') }}'"
                    >
                        <i class="bi bi-plus-circle me-1"></i> Input Data Siswa
                    </button>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    {{-- Filter Tabs --}}
                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('tabelsiswa', array_filter(['search' => $search, 'perPage' => $perPage])) }}"
                               class="btn btn-sm rounded-pill {{ !$filter ? 'btn-primary' : 'btn-outline-secondary' }}">
                                <i class="bi bi-people me-1"></i> Semua
                            </a>
                            <a href="{{ route('tabelsiswa', array_filter(['filter' => 'prestasi', 'search' => $search, 'perPage' => $perPage])) }}"
                               class="btn btn-sm rounded-pill {{ $filter === 'prestasi' ? 'btn-warning text-dark' : 'btn-outline-warning' }}">
                                <i class="bi bi-trophy me-1"></i> Jalur Prestasi
                            </a>
                            <a href="{{ route('tabelsiswa', array_filter(['filter' => 'tahfidz', 'search' => $search, 'perPage' => $perPage])) }}"
                               class="btn btn-sm rounded-pill {{ $filter === 'tahfidz' ? 'btn-success' : 'btn-outline-success' }}">
                                <i class="bi bi-book me-1"></i> Asrama Tahfidz
                            </a>
                            <a href="{{ route('tabelsiswa', array_filter(['filter' => 'both', 'search' => $search, 'perPage' => $perPage])) }}"
                               class="btn btn-sm rounded-pill {{ $filter === 'both' ? 'btn-purple' : 'btn-outline-purple' }}">
                                <i class="bi bi-stars me-1"></i> Prestasi + Tahfidz
                            </a>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-6 mb-3 mb-md-0">
                            <form
                                action="{{ route('tabelsiswa') }}"
                                method="GET"
                            >
                                @if($filter)
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                @endif
                                <input type="hidden" name="perPage" value="{{ $perPage }}">
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
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <form
                                action="{{ route('tabelsiswa') }}"
                                method="GET"
                                class="d-flex justify-content-md-end"
                            >
                                @if($filter)
                                    <input type="hidden" name="filter" value="{{ $filter }}">
                                @endif
                                @if($search)
                                    <input type="hidden" name="search" value="{{ $search }}">
                                @endif
                                <div
                                    class="input-group input-group-sm"
                                    style="max-width: 200px;"
                                >
                                    <label class="input-group-text bg-white text-muted">Tampilkan</label>
                                    <select
                                        class="form-select border-start-0"
                                        name="perPage"
                                        onchange="this.form.submit()"
                                    >
                                        <option
                                            value="10"
                                            {{ ($perPage ?? 10) == 10 ? 'selected' : '' }}
                                        >10</option>
                                        <option
                                            value="25"
                                            {{ ($perPage ?? 10) == 25 ? 'selected' : '' }}
                                        >25</option>
                                        <option
                                            value="50"
                                            {{ ($perPage ?? 10) == 50 ? 'selected' : '' }}
                                        >50</option>
                                        <option
                                            value="100"
                                            {{ ($perPage ?? 10) == 100 ? 'selected' : '' }}
                                        >100</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary">
                            <tr>
                                <th class="ps-3">No</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th class="d-none">Agama</th>
                                <th class="d-none d-md-table-cell">Gender</th>
                                <th class="d-none d-lg-table-cell">Jalur</th>
                                <th class="d-none d-lg-table-cell">Tahfidz</th>
                                <th class="d-none">Status</th>
                                <th class="text-end pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datasiswa as $dt)
                                <tr>
                                    <td class="ps-3">
                                        {{ ($datasiswa->currentPage() - 1) * $datasiswa->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $dt->namasiswa }}</span>
                                    </td>
                                    <td>{{ $dt->jurusan }}</td>
                                    <td class="d-none">{{ $dt->agama ?? '-' }}</td>
                                    <td class="d-none d-md-table-cell">{{ $dt->jeniskelamin }}</td>
                                    <td class="d-none d-lg-table-cell">
                                        @if($dt->jalurdaftar === 'Prestasi')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-trophy-fill me-1"></i>Prestasi
                                            </span>
                                        @elseif($dt->jalurdaftar)
                                            <span class="badge bg-light text-secondary border">{{ $dt->jalurdaftar }}</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if($dt->asrama_tahfidz === 'Bersedia')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill me-1"></i>Bersedia
                                            </span>
                                        @elseif($dt->asrama_tahfidz === 'Tidak')
                                            <span class="text-muted small">Tidak</span>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </td>
                                    <td class="d-none">
                                        <span
                                            class="badge {{ $dt->status_seleksi === 'diterima'
                                                ? 'bg-success'
                                                : ($dt->status_seleksi === 'ditolak'
                                                    ? 'bg-danger'
                                                    : ($dt->status_seleksi === 'dipertimbangkan'
                                                        ? 'bg-warning'
                                                        : 'bg-secondary')) }}"
                                        >
                                            {{ ucfirst($dt->status_seleksi) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2 pe-3">
                                            <a
                                                href="{{ route('siswa.print.surat-keterangan', $dt->id) }}"
                                                class="btn btn-sm btn-outline-info rounded-pill"
                                                target="_blank"
                                                title="Cetak Surat Keterangan"
                                            >
                                                <i class="bi bi-printer"></i><span
                                                    class="d-none d-lg-inline ms-1">Daftar</span>
                                            </a>

                                            <a
                                                href="{{ route('siswa.ubah', $dt->id) }}"
                                                class="btn btn-sm btn-outline-primary rounded-pill"
                                                title="Edit Data"
                                            >
                                                <i class="bi bi-pencil"></i>
                                            </a>



                                            @if ($dt->pembayarans()->exists())
                                                <button
                                                    class="btn btn-sm btn-outline-danger rounded-pill opacity-50"
                                                    disabled
                                                    title="Tidak dapat dihapus karena memiliki pembayaran"
                                                >
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @else
                                                <form
                                                    action="{{ route('siswa.destroy', $dt->id) }}"
                                                    method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-pill"
                                                        title="Hapus Data"
                                                    >
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-success rounded-pill {{ $dt->status_seleksi !== 'diterima' ? 'disabled opacity-50' : '' }}"
                                                data-bs-toggle="popover"
                                                data-bs-trigger="click"
                                                data-bs-html="true"
                                                data-bs-content="
                                                    <p class='mb-2'>Apakah <strong>{{ $dt->namasiswa }}</strong> sudah mengikuti seleksi dan diterima?</p>
                                                    <div class='d-flex justify-content-between gap-2'>
                                                        <button type='button' class='btn btn-outline-secondary btn-sm dismiss-popover'>Batal</button>
                                                        <a href='{{ route('siswa.print.surat-diterima', $dt->id) }}' class='btn btn-success btn-sm' target='_blank'>
                                                            <i class='bi bi-printer'></i> Ya, Cetak
                                                        </a>
                                                    </div>
                                                "
                                                title="{{ $dt->status_seleksi !== 'diterima' ? 'Siswa belum diterima dalam seleksi' : 'Konfirmasi Cetak' }}"
                                                data-bs-placement="left"
                                                {{ $dt->status_seleksi !== 'diterima' ? 'disabled' : '' }}
                                            >
                                                <i class="bi bi-check-circle"></i>
                                                <span class="d-none d-lg-inline ms-1">Terima</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="9"
                                        class="text-center py-4 text-muted"
                                    >
                                        <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                        Data siswa tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-top border-light py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="text-muted small mb-0">
                            Menampilkan {{ $datasiswa->firstItem() ?? 0 }} - {{ $datasiswa->lastItem() ?? 0 }} dari
                            {{ $datasiswa->total() }} data
                        </p>
                        <div>
                            {{ $datasiswa->appends(['search' => $search, 'perPage' => $perPage, 'filter' => $filter])->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .btn-purple {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: #fff;
        }
        .btn-purple:hover {
            background-color: #5a32a3;
            border-color: #5a32a3;
            color: #fff;
        }
        .btn-outline-purple {
            color: #6f42c1;
            border-color: #6f42c1;
        }
        .btn-outline-purple:hover {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: #fff;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #dee2e6;
        }

        .btn-outline-secondary:hover {
            background-color: #f8f9fa;
            color: #6c757d;
            border-color: #dee2e6;
        }

        .popover {
            max-width: 300px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Smooth transitions */
        .btn,
        .form-control,
        .table tr {
            transition: all 0.2s ease;
        }

        /* Make table rows more readable with subtle hover */
        .table tr:hover {
            background-color: rgba(0, 123, 255, 0.03);
        }

        @media (max-width: 768px) {
            .card-header .row {
                flex-direction: column;
            }

            .justify-content-md-end {
                justify-content: flex-start !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all popovers with improved options
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => {
                const popover = new bootstrap.Popover(popoverTriggerEl, {
                    sanitize: false,
                    container: 'body'
                });

                // Add click event listener after popover is shown
                popoverTriggerEl.addEventListener('shown.bs.popover', function() {
                    const dismissButtons = document.querySelectorAll('.dismiss-popover');
                    dismissButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            popover.hide();
                        });
                    });

                    // Close popover when clicking outside
                    document.addEventListener('click', function(event) {
                        if (!popoverTriggerEl.contains(event.target) &&
                            !document.querySelector('.popover')?.contains(event.target)) {
                            popover.hide();
                        }
                    });
                });

                return popover;
            });

            // Add a subtle animation to the table rows for a more modern feel
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                setTimeout(() => {
                    row.style.opacity = '1';
                }, 50 * index);
            });
        });
    </script>
@endpush
