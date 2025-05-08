@extends('partials.master')

@section('isisiswa')
    <main class="app-main bg-light">
        <div class="container py-4">
            <div class="row mb-4 align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-light text-primary mb-0 fs-3">Data Seleksi Siswa Baru</h1>
                </div>

            </div>

            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-white py-3 border-bottom border-light">
                    <div class="row align-items-center">
                        <div class="col-lg-8 col-md-6 mb-3 mb-md-0">
                            <form
                                action="{{ route('seleksi.index') }}"
                                method="GET"
                            >
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
                                <th class="d-none d-md-table-cell">Gender</th>
                                <th>Status</th>
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
                                    <td class="d-none d-md-table-cell">{{ $dt->jeniskelamin }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
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
                                            <select
                                                class="form-select form-select-sm status-select"
                                                data-siswa-id="{{ $dt->id }}"
                                                style="width: 140px;"
                                            >
                                                <option
                                                    value="pending"
                                                    {{ $dt->status_seleksi == 'pending' ? 'selected' : '' }}
                                                >
                                                    Pending
                                                </option>
                                                <option
                                                    value="diterima"
                                                    {{ $dt->status_seleksi == 'diterima' ? 'selected' : '' }}
                                                >
                                                    Diterima
                                                </option>
                                                <option
                                                    value="ditolak"
                                                    {{ $dt->status_seleksi == 'ditolak' ? 'selected' : '' }}
                                                >
                                                    Ditolak
                                                </option>
                                                <option
                                                    value="dipertimbangkan"
                                                    {{ $dt->status_seleksi == 'dipertimbangkan' ? 'selected' : '' }}
                                                >
                                                    Dipertimbangkan
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2 pe-3">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary rounded-pill update-status"
                                                data-siswa-id="{{ $dt->id }}"
                                            >
                                                <i class="bi bi-save me-1"></i> Simpan
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="7"
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
                            {{ $datasiswa->appends(['search' => $search, 'perPage' => $perPage])->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        .btn:focus,
        .form-control:focus,
        .form-select:focus {
            box-shadow: none;
            border-color: #dee2e6;
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

        .form-select option[value="diterima"] {
            background-color: #d1e7dd;
        }

        .form-select option[value="ditolak"] {
            background-color: #f8d7da;
        }

        .form-select option[value="dipertimbangkan"] {
            background-color: #fff3cd;
        }

        .form-select option[value="pending"] {
            background-color: #e2e3e5;
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle status updates
            document.querySelectorAll('.update-status').forEach(button => {
                button.addEventListener('click', async function() {
                    const siswaId = this.dataset.siswaId;
                    const statusSelect = document.querySelector(
                        `.status-select[data-siswa-id="${siswaId}"]`);
                    const newStatus = statusSelect.value;

                    // Show loading state
                    button.disabled = true;
                    button.innerHTML =
                        '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

                    try {
                        const response = await fetch(`/seleksi/${siswaId}/update-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Update the badge immediately
                            const badgeColor = {
                                'diterima': 'bg-success',
                                'ditolak': 'bg-danger',
                                'dipertimbangkan': 'bg-warning',
                                'pending': 'bg-secondary'
                            } [newStatus];

                            const badge = statusSelect.previousElementSibling;
                            badge.className = `badge ${badgeColor}`;
                            badge.textContent = newStatus.charAt(0).toUpperCase() + newStatus
                                .slice(1);

                            // Show success toast
                            const toast = document.createElement('div');
                            toast.className = 'toast position-fixed bottom-0 end-0 m-3';
                            toast.innerHTML = `
                                <div class="toast-body bg-success text-white">
                                    Status berhasil diupdate
                                </div>
                            `;
                            document.body.appendChild(toast);
                            new bootstrap.Toast(toast).show();
                        } else {
                            throw new Error(data.message);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan: ' + error.message);
                    } finally {
                        button.disabled = false;
                        button.innerHTML = '<i class="bi bi-save me-1"></i> Simpan';
                    }
                });
            });
        });
    </script>
@endpush
