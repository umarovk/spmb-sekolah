@extends('partials.master')

@section('isisiswa')
    <div class="dashboard-content">
        <div class="container-fluid py-4">

            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <div>
                    <h1 class="fw-light text-primary mb-1 fs-3">Pengaturan Aplikasi</h1>
                    <p class="text-muted small mb-0">Konfigurasi integrasi pihak ketiga & preferensi sistem</p>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Status efektif (DB > .env) --}}
            <div class="card border-0 shadow-sm rounded-3 mb-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <div class="flex-shrink-0">
                            @if ($effective['configured'])
                                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                                    <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                </div>
                            @else
                                <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width:44px;height:44px;">
                                    <i class="bi bi-exclamation-triangle-fill text-warning fs-4"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-semibold text-dark">
                                Google Sheets:
                                @if ($effective['configured'])
                                    <span class="text-success">Sudah terkonfigurasi</span>
                                @else
                                    <span class="text-warning">Belum lengkap</span>
                                @endif
                            </div>
                            <small class="text-muted">
                                Sumber nilai aktif: prioritas <strong>Database</strong> > fallback <strong>.env</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm">
                @csrf

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-table text-primary me-2"></i>Google Sheets — Jawaban Seleksi
                        </h5>
                        <small class="text-muted">Dipakai oleh halaman "Lihat Jawaban" di menu Seleksi Siswa</small>
                    </div>
                    <div class="card-body p-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                API Key
                                @if (filled($envFallback['api_key']) && empty($settings['google_sheets_api_key']))
                                    <span class="badge bg-light text-secondary border ms-1">dari .env</span>
                                @endif
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       name="google_sheets_api_key"
                                       id="apiKeyInput"
                                       class="form-control @error('google_sheets_api_key') is-invalid @enderror"
                                       value="{{ old('google_sheets_api_key', $settings['google_sheets_api_key']) }}"
                                       placeholder="{{ filled($envFallback['api_key']) ? 'Kosongkan untuk pakai .env (' . substr($envFallback['api_key'], 0, 6) . '...)' : 'AIza...' }}"
                                       autocomplete="off">
                                <button type="button" class="btn btn-outline-secondary" id="toggleApiKey" tabindex="-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">
                                Buat di <a href="https://console.cloud.google.com/apis/credentials" target="_blank" rel="noopener">Google Cloud Console</a> — restrict ke "Google Sheets API".
                            </small>
                            @error('google_sheets_api_key')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Spreadsheet ID
                                @if (filled($envFallback['seleksi_id']) && empty($settings['google_sheets_seleksi_id']))
                                    <span class="badge bg-light text-secondary border ms-1">dari .env</span>
                                @endif
                            </label>
                            <input type="text"
                                   name="google_sheets_seleksi_id"
                                   id="sheetIdInput"
                                   class="form-control @error('google_sheets_seleksi_id') is-invalid @enderror"
                                   value="{{ old('google_sheets_seleksi_id', $settings['google_sheets_seleksi_id']) }}"
                                   placeholder="1AbC...xyz (atau paste link spreadsheet — ID akan diekstrak otomatis)">
                            <small class="text-muted">
                                ID = bagian URL antara <code>/d/</code> dan <code>/edit</code>. Sheet wajib di-share "Anyone with link can view".
                            </small>
                            @error('google_sheets_seleksi_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold">
                                    Range / Sheet Name
                                    @if (filled($envFallback['range']) && empty($settings['google_sheets_seleksi_range']))
                                        <span class="badge bg-light text-secondary border ms-1">dari .env</span>
                                    @endif
                                </label>
                                <input type="text"
                                       name="google_sheets_seleksi_range"
                                       id="rangeInput"
                                       class="form-control @error('google_sheets_seleksi_range') is-invalid @enderror"
                                       value="{{ old('google_sheets_seleksi_range', $settings['google_sheets_seleksi_range']) }}"
                                       placeholder="Sheet1 atau Sheet1!A:Z">
                                <small class="text-muted">Nama tab spreadsheet, contoh: <code>Sheet1</code> atau <code>Jawaban!A:Z</code></small>
                                @error('google_sheets_seleksi_range')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">
                                    Cache TTL (detik)
                                </label>
                                <input type="number"
                                       name="google_sheets_cache_ttl"
                                       min="0"
                                       max="86400"
                                       class="form-control @error('google_sheets_cache_ttl') is-invalid @enderror"
                                       value="{{ old('google_sheets_cache_ttl', $settings['google_sheets_cache_ttl']) }}"
                                       placeholder="{{ $envFallback['cache_ttl'] }}">
                                <small class="text-muted">Default 300 (5 menit)</small>
                                @error('google_sheets_cache_ttl')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Test connection --}}
                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                <button type="button" class="btn btn-outline-primary rounded-pill" id="testBtn">
                                    <i class="bi bi-plug me-1"></i> Test Koneksi
                                </button>
                                <small class="text-muted">Cek apakah API Key dan Spreadsheet ID bisa diakses</small>
                            </div>
                            <div id="testResult" class="mt-3" style="display:none;"></div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary rounded-pill">
                        Reset Form
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-save me-1"></i> Simpan Pengaturan
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Toggle API key visibility
    const apiKeyInput = document.getElementById('apiKeyInput');
    document.getElementById('toggleApiKey').addEventListener('click', function () {
        const isPwd = apiKeyInput.type === 'password';
        apiKeyInput.type = isPwd ? 'text' : 'password';
        this.querySelector('i').className = isPwd ? 'bi bi-eye-slash' : 'bi bi-eye';
    });

    // Auto-extract spreadsheet ID if a full URL is pasted
    const sheetIdInput = document.getElementById('sheetIdInput');
    sheetIdInput.addEventListener('input', function () {
        const m = this.value.match(/\/d\/([a-zA-Z0-9-_]{20,})/);
        if (m) {
            this.value = m[1];
        }
    });

    // Test connection
    const testBtn = document.getElementById('testBtn');
    const testResult = document.getElementById('testResult');
    testBtn.addEventListener('click', async function () {
        const original = testBtn.innerHTML;
        testBtn.disabled = true;
        testBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengetes...';
        testResult.style.display = 'block';
        testResult.innerHTML = '<div class="text-muted small">Mengirim request ke Google Sheets API...</div>';

        const fd = new FormData();
        fd.append('api_key', apiKeyInput.value);
        fd.append('seleksi_id', sheetIdInput.value);
        fd.append('range', document.getElementById('rangeInput').value);
        fd.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route('admin.settings.test-sheets') }}', {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (data.ok) {
                let sampleHtml = '';
                if (data.sample && data.sample.headers && data.sample.headers.length) {
                    sampleHtml = `
                        <div class="mt-3">
                            <small class="text-muted fw-semibold">Preview header kolom:</small>
                            <div class="mt-1">
                                ${data.sample.headers.map(h => `<span class="badge bg-light text-dark border me-1 mb-1">${escapeHtml(h)}</span>`).join('')}
                            </div>
                        </div>
                    `;
                }
                testResult.innerHTML = `
                    <div class="alert alert-success border-0 shadow-sm mb-0">
                        <div class="fw-semibold"><i class="bi bi-check-circle-fill me-2"></i>${escapeHtml(data.message)}</div>
                        ${sampleHtml}
                    </div>`;
            } else {
                testResult.innerHTML = `
                    <div class="alert alert-danger border-0 shadow-sm mb-0">
                        <div class="fw-semibold"><i class="bi bi-x-circle-fill me-2"></i>Koneksi gagal</div>
                        <div class="small mt-1">${escapeHtml(data.message)}</div>
                    </div>`;
            }
        } catch (e) {
            testResult.innerHTML = `<div class="alert alert-danger border-0 shadow-sm mb-0">Error: ${escapeHtml(e.message)}</div>`;
        } finally {
            testBtn.disabled = false;
            testBtn.innerHTML = original;
        }
    });

    function escapeHtml(s) {
        return String(s).replace(/[&<>"']/g, c => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
        }[c]));
    }
});
</script>
@endpush
