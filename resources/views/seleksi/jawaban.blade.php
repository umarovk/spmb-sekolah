@extends('partials.master')

@section('isisiswa')
    <div class="dashboard-content">
        <div class="container-fluid py-4">

            {{-- Header & back button --}}
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h1 class="fw-light text-primary mb-1 fs-3">Jawaban Seleksi Siswa</h1>
                    <p class="text-muted small mb-0">Data dibaca langsung dari Google Spreadsheet</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </a>
                    @if ($configured)
                        <a href="{{ route('seleksi.jawaban', ['id' => $siswa->id, 'refresh' => 1]) }}"
                           class="btn btn-outline-primary rounded-pill"
                           title="Ambil ulang data dari spreadsheet">
                            <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                        </a>
                    @endif
                </div>
            </div>

            {{-- Student info card --}}
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-body py-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <small class="text-muted text-uppercase fw-semibold" style="letter-spacing: .5px;">Nama Siswa</small>
                            <div class="fs-4 fw-semibold text-dark">{{ $siswa->namasiswa }}</div>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase fw-semibold" style="letter-spacing: .5px;">Jurusan</small>
                            <div class="fs-6 text-dark">{{ $siswa->jurusan ?: '-' }}</div>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted text-uppercase fw-semibold" style="letter-spacing: .5px;">Status</small>
                            <div>
                                <span class="badge {{ $siswa->status_seleksi === 'diterima' ? 'bg-success' : ($siswa->status_seleksi === 'ditolak' ? 'bg-danger' : ($siswa->status_seleksi === 'dipertimbangkan' ? 'bg-warning' : 'bg-secondary')) }}">
                                    {{ ucfirst($siswa->status_seleksi) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Answers / states --}}
            @if (! $configured)
                <div class="alert alert-warning border-0 shadow-sm rounded-3">
                    <h5 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Google Sheets belum dikonfigurasi</h5>
                    <p class="mb-2">Set variabel berikut di file <code>.env</code> lalu jalankan <code>php artisan config:clear</code>:</p>
                    <pre class="bg-light p-3 rounded small mb-0"><code>GOOGLE_SHEETS_API_KEY=your_api_key
GOOGLE_SHEETS_SELEKSI_ID=spreadsheet_id
GOOGLE_SHEETS_SELEKSI_RANGE=Sheet1</code></pre>
                </div>
            @elseif (! $data)
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                        <h5 class="text-dark mb-2">Jawaban tidak ditemukan</h5>
                        <p class="text-muted mb-0">
                            Nama <strong>"{{ $siswa->namasiswa }}"</strong> tidak ada di spreadsheet.<br>
                            Pastikan nama di kolom "Nama" spreadsheet sama persis (huruf besar/kecil dan spasi diabaikan).
                        </p>
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="mb-0 text-dark"><i class="bi bi-journal-check text-primary me-2"></i>Jawaban Peserta</h5>
                            <small class="text-muted">Total {{ count($data['answers']) }} pertanyaan</small>
                        </div>
                        <small class="text-muted">
                            Cocok dengan baris: <strong>{{ $data['nama'] }}</strong>
                        </small>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach ($data['answers'] as $question => $answer)
                                <div class="col-md-6">
                                    <div class="qa-item h-100 p-3 rounded-3 border bg-light-subtle">
                                        <div class="qa-question text-muted small fw-semibold mb-2">
                                            <i class="bi bi-question-circle text-primary me-1"></i>
                                            {{ $question }}
                                        </div>
                                        <div class="qa-answer fs-5 text-dark fw-medium">
                                            @if (trim((string) $answer) === '')
                                                <span class="text-muted fst-italic fs-6">(tidak diisi)</span>
                                            @else
                                                {{ $answer }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .qa-item {
            background-color: #f8f9fb;
            border-color: #e9ecef !important;
            transition: all 0.2s ease;
        }
        .qa-item:hover {
            background-color: #fff;
            border-color: #c7d2fe !important;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08);
        }
        .qa-question {
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-size: 0.78rem;
        }
        .qa-answer {
            line-height: 1.5;
            word-break: break-word;
        }
    </style>
@endpush
