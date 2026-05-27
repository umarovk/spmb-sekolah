@extends('partials.master')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('css/bahan.css') }}"
    >
@endpush

@section('content')
    <div class="bahan-page">
        <div class="container-fluid">

            {{-- HEADER --}}
            <div class="bahan-header">
                <div class="bahan-header-icon">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="bahan-header-text">
                    <h1 class="bahan-title">Tracking Pengambilan Bahan Siswa</h1>
                    <p class="bahan-subtitle">Rekap distribusi 7 jenis bahan per siswa</p>
                </div>
                <div class="bahan-header-action">
                    <a
                        href="{{ route('bahan.export') }}"
                        class="btn btn-success"
                    >
                        <i class="bi bi-download"></i> Export CSV
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                    ></button>
                </div>
            @endif

            {{-- SUMMARY SISWA --}}
            <div class="bahan-summary-grid">
                <div class="b-summary b-summary-total">
                    <div class="b-summary-num">{{ $rekapSiswa['total'] }}</div>
                    <div class="b-summary-lbl">Total Siswa</div>
                </div>
                <div class="b-summary b-summary-lengkap">
                    <div class="b-summary-num">{{ $rekapSiswa['lengkap'] }}</div>
                    <div class="b-summary-lbl">Lengkap (7/7)</div>
                </div>
                <div class="b-summary b-summary-sebagian">
                    <div class="b-summary-num">{{ $rekapSiswa['sebagian'] }}</div>
                    <div class="b-summary-lbl">Sebagian</div>
                </div>
                <div class="b-summary b-summary-belum">
                    <div class="b-summary-num">{{ $rekapSiswa['belum'] }}</div>
                    <div class="b-summary-lbl">Belum Ambil</div>
                </div>
            </div>

            {{-- REKAP PER ITEM --}}
            <div class="bahan-section-title">
                <i class="bi bi-bar-chart-line"></i> Rekap Distribusi per Jenis Bahan
            </div>
            <div class="bahan-items-grid">
                @foreach ($rekapItems as $it)
                    <div class="b-item-card">
                        <div class="b-item-head">
                            <div class="b-item-icon">
                                <i class="bi bi-bag-check"></i>
                            </div>
                            <div class="b-item-name">{{ $it['nama'] }}</div>
                        </div>
                        <div class="b-item-stats">
                            <div class="b-item-num">
                                <span class="b-item-num-val">{{ $it['sudah'] }}</span>
                                <span class="b-item-num-sep">/</span>
                                <span class="b-item-num-tot">{{ $rekapSiswa['total'] }}</span>
                            </div>
                            <div class="b-item-pill b-item-pill-belum">
                                <i class="bi bi-exclamation-circle"></i> {{ $it['belum'] }} belum
                            </div>
                        </div>
                        <div class="b-progress">
                            <div
                                class="b-progress-bar"
                                style="width: {{ $it['persen'] }}%"
                            ></div>
                        </div>
                        <div class="b-item-percent">{{ $it['persen'] }}% terdistribusi</div>
                    </div>
                @endforeach
            </div>

            {{-- FILTER & TABEL --}}
            <div class="bahan-card">
                <div class="bahan-card-header">
                    <h3 class="bahan-card-title"><i class="bi bi-people"></i> Daftar Siswa</h3>
                </div>
                <div class="bahan-card-body">
                    <form
                        action="{{ route('bahan.index') }}"
                        method="GET"
                        class="bahan-filter-row"
                    >
                        <div class="b-filter-search">
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-search"></i></span>
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Cari nama atau NISN..."
                                    value="{{ $search }}"
                                >
                            </div>
                        </div>
                        <select
                            name="status"
                            class="form-select b-filter-select"
                            onchange="this.form.submit()"
                        >
                            <option value="">Semua Status Siswa</option>
                            <option
                                value="lengkap"
                                {{ $status === 'lengkap' ? 'selected' : '' }}
                            >Lengkap (7/7)</option>
                            <option
                                value="sebagian"
                                {{ $status === 'sebagian' ? 'selected' : '' }}
                            >Sebagian</option>
                            <option
                                value="belum"
                                {{ $status === 'belum' ? 'selected' : '' }}
                            >Belum Ambil</option>
                        </select>
                        <select
                            name="jenis"
                            class="form-select b-filter-select"
                            onchange="this.form.submit()"
                        >
                            <option value="">Semua Jenis Bahan</option>
                            @foreach ($items as $it)
                                <option
                                    value="{{ $it }}"
                                    {{ $jenisFilter === $it ? 'selected' : '' }}
                                >{{ $it }}</option>
                            @endforeach
                        </select>
                        <button
                            type="submit"
                            class="btn btn-primary"
                        ><i class="bi bi-funnel"></i> Filter</button>
                        @if ($search || $status || $jenisFilter)
                            <a
                                href="{{ route('bahan.index') }}"
                                class="btn btn-outline-secondary"
                            >
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        @endif
                    </form>

                    <div class="table-responsive">
                        <table class="table bahan-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Jurusan</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Belum Diambil</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswas as $i => $siswa)
                                    <tr>
                                        <td data-label="No">{{ $i + 1 }}</td>
                                        <td data-label="Nama">
                                            <div class="b-siswa-name">{{ $siswa->namasiswa }}</div>
                                            <small class="text-muted">NISN: {{ $siswa->nisn ?: '-' }}</small>
                                        </td>
                                        <td data-label="Jurusan">
                                            <span class="badge bg-light text-dark border">{{ $siswa->jurusan }}</span>
                                        </td>
                                        <td
                                            data-label="Progress"
                                            style="min-width: 180px;"
                                        >
                                            <div class="b-progress b-progress-sm">
                                                <div
                                                    class="b-progress-bar"
                                                    style="width: {{ $siswa->progress_percent }}%"
                                                ></div>
                                            </div>
                                            <small class="text-muted">{{ $siswa->taken_count }}/{{ $siswa->total_items }} item ({{ $siswa->progress_percent }}%)</small>
                                        </td>
                                        <td data-label="Status">
                                            @if ($siswa->status_label === 'lengkap')
                                                <span class="badge bahan-badge-lengkap"><i class="bi bi-check-circle-fill"></i> Lengkap</span>
                                            @elseif ($siswa->status_label === 'sebagian')
                                                <span class="badge bahan-badge-sebagian"><i class="bi bi-hourglass-split"></i> Sebagian</span>
                                            @else
                                                <span class="badge bahan-badge-belum"><i class="bi bi-x-circle-fill"></i> Belum Ambil</span>
                                            @endif
                                        </td>
                                        <td data-label="Belum Diambil">
                                            @if ($siswa->items_missing->isEmpty())
                                                <span class="text-success small"><i class="bi bi-check2-all"></i> Semua lengkap</span>
                                            @else
                                                <div class="b-missing-list">
                                                    @foreach ($siswa->items_missing as $miss)
                                                        <span class="b-missing-chip">{{ $miss }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td
                                            data-label="Aksi"
                                            class="text-end"
                                        >
                                            <a
                                                href="{{ route('bahan.manage', $siswa->id) }}"
                                                class="btn btn-sm btn-primary"
                                            >
                                                <i class="bi bi-pencil-square"></i> Kelola
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            colspan="7"
                                            class="text-center py-4 text-muted"
                                        >
                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                            Tidak ada data siswa
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
