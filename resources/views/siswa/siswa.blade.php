@extends('partials.master')

@section('isisiswa')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h1>Data Calon Siswa Baru</h1>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <button
                            class="btn btn-success"
                            onclick="window.location.href='{{ route('siswa.create') }}'"
                        >
                            Input data siswa
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-8">
                                        <form
                                            action="{{ route('tabelsiswa') }}"
                                            method="GET"
                                            class="form-inline"
                                        >
                                            <div class="input-group">
                                                <input
                                                    type="text"
                                                    name="search"
                                                    class="form-control"
                                                    placeholder="Cari nama siswa..."
                                                    value="{{ $search ?? '' }}"
                                                >
                                                <button
                                                    class="btn btn-primary"
                                                    type="submit"
                                                >
                                                    <i class="bi bi-search"></i> Cari
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="float-end">
                                            <form
                                                action="{{ route('tabelsiswa') }}"
                                                method="GET"
                                                class="form-inline"
                                            >
                                                <div class="input-group">
                                                    <label class="input-group-text">Tampilkan</label>
                                                    <select
                                                        class="form-select"
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
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nomor</th>
                                        <th>Nama</th>
                                        <th>Jurusan</th>
                                        <th>Agama</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($datasiswa as $dt)
                                        <tr>
                                            <td>{{ ($datasiswa->currentPage() - 1) * $datasiswa->perPage() + $loop->iteration }}
                                            </td>
                                            {{-- <td>{{ $loop->iteration }}</td> --}}
                                            <td>{{ $dt->namasiswa }}</td>
                                            <td>{{ $dt->jurusan }}</td>
                                            <td>{{ $dt->agama ?? '-' }}</td>
                                            <td>{{ $dt->jeniskelamin }}</td>
                                            <td><a
                                                    href="{{ route('siswa.print.surat-keterangan', $dt->id) }}"
                                                    class="btn btn-info"
                                                    target="_blank"
                                                    title="Cetak Surat Keterangan"
                                                >
                                                    <i class="bi bi-printer"></i> Daftar
                                                </a></td>
                                            <td>

                                                @if ($dt->pembayarans()->exists())
                                                    <button
                                                        class="btn btn-danger"
                                                        disabled
                                                        title="Tidak dapat dihapus karena memiliki pembayaran"
                                                    >
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                @else
                                                    <form
                                                        action="{{ route('siswa.destroy', $dt->id) }}"
                                                        method="POST"
                                                        style="display:inline;"
                                                        onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')"
                                                    >
                                                        @csrf
                                                        @method('DELETE')
                                                        <button
                                                            type="submit"
                                                            class="btn btn-danger"
                                                        >
                                                            <i class="bi bi-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                                <a
                                                    href="{{ route('siswa.editdata', $dt->id) }}"
                                                    class="btn btn-primary"
                                                >
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>

                                                <button
                                                    type="button"
                                                    class="btn btn-success"
                                                    data-bs-toggle="popover"
                                                    data-bs-trigger="click"
                                                    data-bs-html="true"
                                                    data-bs-content="
                                                            <p>Apakah <strong>{{ $dt->namasiswa }}</strong> sudah mengikuti seleksi dan diterima?</p>
                                                            <div class='d-flex justify-content-between mt-2'>
                                                                <button type='button' class='btn btn-secondary btn-sm dismiss-popover'>Batal</button>
                                                                <a href='{{ route('siswa.print.surat-diterima', $dt->id) }}' class='btn btn-success btn-sm' target='_blank'>
                                                                    <i class='bi bi-printer'></i> Ya, Cetak
                                                                </a>
                                                            </div>
                                                        "
                                                    title="Konfirmasi Cetak"
                                                >
                                                    <i class="bi bi-printer"></i> Terima
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td
                                                colspan="7"
                                                class="text-center"
                                            >Data siswa tidak ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer">
                            <div class="mb-4 mt-4">

                                <div class="d-flex justify-content-end">
                                    {{ $datasiswa->appends(['search' => $search, 'perPage' => $perPage])->links('vendor.pagination.custom') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all popovers
            const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
            const popoverList = [...popoverTriggerList].map(popoverTriggerEl => {
                const popover = new bootstrap.Popover(popoverTriggerEl, {
                    sanitize: false
                });

                // Add click event listener after popover is shown
                popoverTriggerEl.addEventListener('shown.bs.popover', function() {
                    const dismissButtons = document.querySelectorAll('.dismiss-popover');
                    dismissButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            popover.hide();
                        });
                    });
                });

                return popover;
            });
        });
    </script>
@endpush
