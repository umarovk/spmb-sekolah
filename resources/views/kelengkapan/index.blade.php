@extends('partials.master')

@section('isisiswa')
<div class="dashboard-content">
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="fw-light text-primary mb-1 fs-3">
                    <i class="bi bi-clipboard2-check me-2"></i>Kelengkapan Data Siswa
                </h1>
                <p class="text-muted small mb-0">
                    Progres pengisian data berdasarkan {{ count($requiredFields) }} field wajib.
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.settings.index') }}#req-fields" class="text-decoration-none ms-1">
                                <i class="bi bi-gear"></i> atur field wajib
                            </a>
                        @endif
                    @endauth
                </p>
            </div>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        {{-- ===== Ringkasan overall ===== --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <div class="text-muted small text-uppercase fw-semibold" style="letter-spacing:1px;">Rata-rata Kelengkapan</div>
                                <h2 class="mb-0 fw-bold" style="font-size:2.4rem;">{{ $avgPercentage }}<span class="fs-4 text-muted">%</span></h2>
                            </div>
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:64px;height:64px;background:{{ $avgPercentage >= 80 ? '#d1fae5' : ($avgPercentage >= 50 ? '#fef3c7' : '#fee2e2') }};">
                                <i class="bi {{ $avgPercentage >= 80 ? 'bi-check-circle-fill text-success' : ($avgPercentage >= 50 ? 'bi-exclamation-triangle-fill text-warning' : 'bi-x-circle-fill text-danger') }} fs-3"></i>
                            </div>
                        </div>
                        <div class="progress mt-3" style="height:10px;border-radius:8px;">
                            <div class="progress-bar {{ $avgPercentage >= 80 ? 'bg-success' : ($avgPercentage >= 50 ? 'bg-warning' : 'bg-danger') }}"
                                 role="progressbar"
                                 style="width: {{ $avgPercentage }}%"
                                 aria-valuenow="{{ $avgPercentage }}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted mt-2 d-block">
                            Dari {{ $totalAll }} siswa terdaftar.
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-check-circle-fill text-success fs-1 mb-2"></i>
                        <div class="h3 fw-bold mb-0">{{ $countComplete }}</div>
                        <small class="text-muted">Data lengkap</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body p-4 text-center">
                        <i class="bi bi-exclamation-triangle-fill text-warning fs-1 mb-2"></i>
                        <div class="h3 fw-bold mb-0">{{ $countIncomplete }}</div>
                        <small class="text-muted">Belum lengkap</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== Filter + Search ===== --}}
        <div class="card border-0 shadow-sm rounded-3 mb-3">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('kelengkapan.index') }}" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ $q }}"
                                   class="form-control" placeholder="Cari nama / NISN / NIS / NIK">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="filter" value="all" id="f-all" {{ $filter === 'all' ? 'checked' : '' }} autocomplete="off">
                            <label class="btn btn-outline-primary" for="f-all">Semua</label>

                            <input type="radio" class="btn-check" name="filter" value="incomplete" id="f-inc" {{ $filter === 'incomplete' ? 'checked' : '' }} autocomplete="off">
                            <label class="btn btn-outline-warning" for="f-inc">Belum Lengkap</label>

                            <input type="radio" class="btn-check" name="filter" value="complete" id="f-com" {{ $filter === 'complete' ? 'checked' : '' }} autocomplete="off">
                            <label class="btn btn-outline-success" for="f-com">Lengkap</label>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-funnel me-1"></i> Terapkan
                        </button>
                        @if ($q || $filter !== 'all')
                            <a href="{{ route('kelengkapan.index') }}" class="btn btn-outline-secondary" title="Reset filter">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- ===== Tabel siswa + progress ===== --}}
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:48px;">#</th>
                                <th>Nama</th>
                                <th class="d-none d-md-table-cell">Jurusan</th>
                                <th class="d-none d-lg-table-cell">Sekolah Asal</th>
                                <th style="width:32%;">Progress</th>
                                <th class="text-end" style="width:160px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $i => $r)
                                @php
                                    $pct = (int) $r['percentage'];
                                    $color = $pct >= 100 ? 'success' : ($pct >= 60 ? 'warning' : 'danger');
                                @endphp
                                <tr>
                                    <td class="text-muted small">{{ ($page - 1) * $perPage + $i + 1 }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $r['nama'] ?: '(tanpa nama)' }}</div>
                                        @if (count($r['missing']) > 0)
                                            <div class="text-muted small">
                                                Belum diisi:
                                                @foreach (array_slice($r['missing'], 0, 3) as $mf)
                                                    <span class="badge bg-light text-danger border me-1">{{ $fieldLabels[$mf] ?? $mf }}</span>
                                                @endforeach
                                                @if (count($r['missing']) > 3)
                                                    <span class="badge bg-light text-muted border">+{{ count($r['missing']) - 3 }} lagi</span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="d-none d-md-table-cell small">{{ $r['jurusan'] ?: '-' }}</td>
                                    <td class="d-none d-lg-table-cell small">{{ $r['sekolah'] ?: '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress flex-grow-1" style="height:8px;border-radius:6px;min-width:80px;">
                                                <div class="progress-bar bg-{{ $color }}"
                                                     role="progressbar"
                                                     style="width:{{ $pct }}%"
                                                     aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="small fw-semibold text-{{ $color }}" style="min-width:48px;text-align:right;">{{ $pct }}%</span>
                                        </div>
                                        <small class="text-muted">{{ $r['filled'] }} / {{ $r['total'] }} field terisi</small>
                                    </td>
                                    <td class="text-end">
                                        @if ($pct >= 100)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-2">
                                                <i class="bi bi-check2"></i> Lengkap
                                            </span>
                                        @else
                                            <a href="{{ route('siswa.ubah', $r['id']) }}?missing={{ implode(',', $r['missing']) }}#kelengkapan-banner"
                                               class="btn btn-sm btn-warning rounded-pill px-3">
                                                <i class="bi bi-pencil-square me-1"></i> Lengkapi
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada data siswa yang cocok dengan filter.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pagination sederhana --}}
        @php
            $totalPages = max(1, (int) ceil($total / $perPage));
        @endphp
        @if ($totalPages > 1)
            <nav class="mt-3">
                <ul class="pagination justify-content-center mb-0">
                    @for ($p = 1; $p <= $totalPages; $p++)
                        <li class="page-item {{ $p === $page ? 'active' : '' }}">
                            <a class="page-link"
                               href="{{ route('kelengkapan.index', ['page' => $p, 'q' => $q, 'filter' => $filter]) }}">
                                {{ $p }}
                            </a>
                        </li>
                    @endfor
                </ul>
            </nav>
        @endif

    </div>
</div>
@endsection
