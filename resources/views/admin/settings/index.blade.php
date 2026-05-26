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

            <form method="POST" action="{{ route('admin.settings.update') }}" id="settingsForm" enctype="multipart/form-data">
                @csrf

                {{-- Identitas Aplikasi (Nama, Tagline, Favicon) --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-window-stack text-primary me-2"></i>Identitas Aplikasi
                        </h5>
                        <small class="text-muted">Nama & icon yang tampil pada tab browser, halaman login, dan layout aplikasi</small>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Aplikasi (Title Tab)</label>
                                <input type="text"
                                       name="app_name"
                                       class="form-control @error('app_name') is-invalid @enderror"
                                       value="{{ old('app_name', $settings['app_name']) }}"
                                       placeholder="SPMB — SMK Cokroaminoto"
                                       maxlength="100">
                                <small class="text-muted">Tampil di title tab browser. Kosongkan untuk pakai default "SPMB".</small>
                                @error('app_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tagline / Deskripsi Singkat</label>
                                <input type="text"
                                       name="app_tagline"
                                       class="form-control @error('app_tagline') is-invalid @enderror"
                                       value="{{ old('app_tagline', $settings['app_tagline']) }}"
                                       placeholder="Sistem Penerimaan Murid Baru"
                                       maxlength="200">
                                <small class="text-muted">Tampil di halaman login sebagai sub-judul.</small>
                                @error('app_tagline')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="form-label fw-semibold">Favicon / Icon Tab</label>
                            <div class="d-flex align-items-center gap-3 flex-wrap">
                                <div class="border rounded-3 d-flex align-items-center justify-content-center bg-light-subtle"
                                     style="width:64px;height:64px;flex-shrink:0;">
                                    @if (filled($settings['app_favicon']) && file_exists(public_path($settings['app_favicon'])))
                                        <img src="{{ asset($settings['app_favicon']) }}?v={{ time() }}" alt="Favicon" style="max-width:48px;max-height:48px;">
                                    @else
                                        <img src="{{ asset('favicon.ico') }}" alt="Favicon default" style="max-width:48px;max-height:48px;">
                                    @endif
                                </div>
                                <div class="flex-grow-1" style="min-width:240px;">
                                    <input type="file"
                                           name="app_favicon"
                                           accept=".png,.jpg,.jpeg,.ico,.svg,.webp"
                                           class="form-control @error('app_favicon') is-invalid @enderror">
                                    <small class="text-muted">PNG / ICO / SVG, ukuran ideal 32×32 atau 64×64. Maks 512 KB.</small>
                                    @error('app_favicon')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                @if (filled($settings['app_favicon']))
                                    <div class="form-check ms-2">
                                        <input class="form-check-input" type="checkbox" name="app_favicon_reset" value="1" id="app_favicon_reset">
                                        <label class="form-check-label small text-danger" for="app_favicon_reset">
                                            Reset ke default
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Konten Halaman Login (deskripsi, alur, role) --}}
                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-card-text text-primary me-2"></i>Konten Halaman Login
                        </h5>
                        <small class="text-muted">
                            Atur teks deskripsi aplikasi, langkah-langkah alur, dan daftar role yang tampil di panel kiri halaman login.
                            Gunakan <code>**teks**</code> untuk membuat <strong>tebal</strong>.
                        </small>
                    </div>
                    <div class="card-body p-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi Aplikasi</label>
                            <textarea name="login_description"
                                      class="form-control @error('login_description') is-invalid @enderror"
                                      rows="3"
                                      maxlength="1000"
                                      placeholder="{{ $loginContent['defaults']['description'] }}">{{ old('login_description', $settings['login_description']) }}</textarea>
                            <small class="text-muted">Paragraf singkat (1-3 kalimat). Tampil di atas daftar alur.</small>
                            @error('login_description')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Langkah Alur Aplikasi</label>
                            <textarea name="login_flow_steps"
                                      class="form-control @error('login_flow_steps') is-invalid @enderror"
                                      rows="6"
                                      maxlength="2000"
                                      placeholder="Satu baris = satu langkah">{{ old('login_flow_steps', implode("\n", $loginContent['flow_steps'])) }}</textarea>
                            <small class="text-muted">Tulis <strong>satu baris untuk satu langkah</strong>. Nomor urut akan diberikan otomatis.</small>
                            @error('login_flow_steps')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-2 fw-semibold d-flex justify-content-between align-items-center">
                            <span>Daftar Role Pengguna</span>
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" id="addRoleBtn">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Role
                            </button>
                        </div>
                        <div class="border rounded-3 p-3 bg-light-subtle">
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0" id="rolesTable">
                                    <thead>
                                        <tr class="small text-muted">
                                            <th style="width:34%;">Icon
                                                <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener" class="text-decoration-none small">
                                                    <i class="bi bi-info-circle"></i>
                                                </a>
                                            </th>
                                            <th style="width:22%;">Nama Role</th>
                                            <th>Deskripsi</th>
                                            <th style="width:50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="rolesTbody">
                                        @foreach ($loginContent['roles'] as $r)
                                            <tr>
                                                <td>
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text bg-white">
                                                            <i class="bi {{ $r['icon'] ?? 'bi-person' }} role-icon-preview"></i>
                                                        </span>
                                                        <input type="text" name="login_roles_icon[]"
                                                               value="{{ $r['icon'] ?? '' }}"
                                                               class="form-control form-control-sm role-icon-input"
                                                               placeholder="bi-person">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="login_roles_name[]"
                                                           value="{{ $r['name'] ?? '' }}"
                                                           class="form-control form-control-sm"
                                                           maxlength="50"
                                                           placeholder="Admin">
                                                </td>
                                                <td>
                                                    <input type="text" name="login_roles_description[]"
                                                           value="{{ $r['description'] ?? '' }}"
                                                           class="form-control form-control-sm"
                                                           maxlength="200"
                                                           placeholder="Deskripsi singkat role">
                                                </td>
                                                <td class="text-end">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-role-btn" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Icon class menggunakan
                                <a href="https://icons.getbootstrap.com/" target="_blank" rel="noopener">Bootstrap Icons</a>
                                (contoh: <code>bi-shield-lock-fill</code>, <code>bi-cash-coin</code>).
                            </small>
                        </div>

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="login_reset" value="1" id="login_reset">
                            <label class="form-check-label small text-danger" for="login_reset">
                                Reset konten halaman login ke default (mengabaikan field di atas)
                            </label>
                        </div>
                    </div>
                </div>

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

                <div class="card border-0 shadow-sm rounded-3 mb-4">
                    <div class="card-header bg-white py-3 border-bottom border-light">
                        <h5 class="mb-0 text-dark">
                            <i class="bi bi-clipboard-data text-primary me-2"></i>Google Sheets — Pendaftaran Online
                        </h5>
                        <small class="text-muted">Dipakai oleh search bar di halaman "Tambah Siswa" untuk autofill data dari Google Form</small>
                    </div>
                    <div class="card-body p-4">

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                API Key Pendaftaran
                                @if (filled($envFallback['pendaftaran_api_key']) && empty($settings['google_sheets_pendaftaran_api_key']))
                                    <span class="badge bg-light text-secondary border ms-1">dari .env</span>
                                @endif
                            </label>
                            <div class="input-group">
                                <input type="password"
                                       name="google_sheets_pendaftaran_api_key"
                                       id="pendaftaranApiKeyInput"
                                       class="form-control"
                                       value="{{ old('google_sheets_pendaftaran_api_key', $settings['google_sheets_pendaftaran_api_key']) }}"
                                       placeholder="{{ filled($envFallback['pendaftaran_api_key']) ? 'Kosongkan untuk pakai .env' : 'AIza...' }}"
                                       autocomplete="off">
                                <button type="button" class="btn btn-outline-secondary" id="togglePendaftaranApiKey" tabindex="-1">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">API Key boleh sama atau berbeda dengan Seleksi.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Spreadsheet ID Pendaftaran
                                @if (filled($envFallback['pendaftaran_id']) && empty($settings['google_sheets_pendaftaran_id']))
                                    <span class="badge bg-light text-secondary border ms-1">dari .env</span>
                                @endif
                            </label>
                            <input type="text"
                                   name="google_sheets_pendaftaran_id"
                                   id="pendaftaranSheetIdInput"
                                   class="form-control"
                                   value="{{ old('google_sheets_pendaftaran_id', $settings['google_sheets_pendaftaran_id']) }}"
                                   placeholder="1AbC...xyz (atau paste link spreadsheet)">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Range / Sheet Name
                                @if (filled($envFallback['pendaftaran_range']) && empty($settings['google_sheets_pendaftaran_range']))
                                    <span class="badge bg-light text-secondary border ms-1">dari .env</span>
                                @endif
                            </label>
                            <input type="text"
                                   name="google_sheets_pendaftaran_range"
                                   id="pendaftaranRangeInput"
                                   class="form-control"
                                   value="{{ old('google_sheets_pendaftaran_range', $settings['google_sheets_pendaftaran_range']) }}"
                                   placeholder="Sheet1 atau Form Responses 1!A:Z">
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                                <button type="button" class="btn btn-outline-primary rounded-pill" id="testPendaftaranBtn">
                                    <i class="bi bi-plug me-1"></i> Test Koneksi
                                </button>
                                <button type="button" class="btn btn-outline-primary rounded-pill" id="fetchHeadersBtn">
                                    <i class="bi bi-arrow-clockwise me-1"></i> Ambil Header dari Sheet
                                </button>
                                <small class="text-muted">Test koneksi cek akses; Ambil Header muat ulang kolom utk mapping.</small>
                            </div>
                            <div id="testPendaftaranResult" class="mb-2" style="display:none;"></div>

                            <div class="mb-2 fw-semibold">Mapping Kolom Gform → Field Siswa</div>
                            <div class="border rounded-3 p-3 bg-light-subtle" id="mappingContainer">
                                @if (empty($pendaftaranMapping))
                                    <div class="text-muted small" id="mappingEmpty">
                                        Belum ada mapping. Klik <strong>Ambil Header dari Sheet</strong> untuk mulai.
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-sm align-middle mb-0" id="mappingTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:50%;">Header di Google Form</th>
                                                    <th style="width:50%;">Field Siswa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pendaftaranMapping as $header => $field)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="mapping_keys[]" value="{{ $header }}">
                                                            <code>{{ $header }}</code>
                                                        </td>
                                                        <td>
                                                            <select name="mapping[{{ $header }}]" class="form-select form-select-sm">
                                                                <option value="">-- skip --</option>
                                                                @foreach ($siswaFields as $sf)
                                                                    <option value="{{ $sf }}" @selected($sf === $field)>{{ $sf }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                            <div id="fetchHeadersResult" class="mt-2"></div>
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

    // Pendaftaran API key visibility
    const pendaftaranApiKeyInput = document.getElementById('pendaftaranApiKeyInput');
    document.getElementById('togglePendaftaranApiKey').addEventListener('click', function () {
        const isPwd = pendaftaranApiKeyInput.type === 'password';
        pendaftaranApiKeyInput.type = isPwd ? 'text' : 'password';
        this.querySelector('i').className = isPwd ? 'bi bi-eye-slash' : 'bi bi-eye';
    });

    // Pendaftaran sheet ID auto-extract from URL
    const pendaftaranSheetIdInput = document.getElementById('pendaftaranSheetIdInput');
    pendaftaranSheetIdInput.addEventListener('input', function () {
        const m = this.value.match(/\/d\/([a-zA-Z0-9-_]{20,})/);
        if (m) this.value = m[1];
    });

    // Siswa fields available for mapping
    const SISWA_FIELDS = @json($siswaFields);
    // Existing mapping from DB
    const EXISTING_MAPPING = @json($pendaftaranMapping);

    function renderMappingTable(headers) {
        const container = document.getElementById('mappingContainer');
        if (!headers || !headers.length) {
            container.innerHTML = '<div class="text-muted small">Tidak ada kolom terdeteksi.</div>';
            return;
        }
        const options = ['<option value="">-- skip --</option>']
            .concat(SISWA_FIELDS.map(f => `<option value="${escapeHtml(f)}">${escapeHtml(f)}</option>`))
            .join('');

        const rows = headers.map(h => {
            const sel = EXISTING_MAPPING[h] || '';
            const opts = ['<option value="">-- skip --</option>']
                .concat(SISWA_FIELDS.map(f =>
                    `<option value="${escapeHtml(f)}" ${f === sel ? 'selected' : ''}>${escapeHtml(f)}</option>`
                ))
                .join('');
            return `
                <tr>
                    <td><code>${escapeHtml(h)}</code></td>
                    <td>
                        <select name="mapping[${escapeHtml(h)}]" class="form-select form-select-sm">
                            ${opts}
                        </select>
                    </td>
                </tr>`;
        }).join('');

        container.innerHTML = `
            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width:50%;">Header di Google Form</th>
                            <th style="width:50%;">Field Siswa</th>
                        </tr>
                    </thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>`;
    }

    document.getElementById('testPendaftaranBtn').addEventListener('click', async function () {
        const btn = this;
        const result = document.getElementById('testPendaftaranResult');
        const original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Mengetes...';
        result.style.display = 'block';
        result.innerHTML = '<div class="text-muted small">Mengirim request ke Google Sheets API...</div>';

        const fd = new FormData();
        fd.append('api_key', pendaftaranApiKeyInput.value);
        fd.append('sheet_id', pendaftaranSheetIdInput.value);
        fd.append('range', document.getElementById('pendaftaranRangeInput').value);
        fd.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route('admin.settings.fetch-pendaftaran-headers') }}', {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.ok) {
                let sampleHtml = '';
                if (data.sample && data.sample.headers && data.sample.headers.length) {
                    sampleHtml = `
                        <div class="mt-2">
                            <small class="text-muted fw-semibold">Preview header kolom:</small>
                            <div class="mt-1">
                                ${data.sample.headers.map(h => `<span class="badge bg-light text-dark border me-1 mb-1">${escapeHtml(h)}</span>`).join('')}
                            </div>
                        </div>`;
                }
                result.innerHTML = `
                    <div class="alert alert-success border-0 shadow-sm mb-0">
                        <div class="fw-semibold"><i class="bi bi-check-circle-fill me-2"></i>${escapeHtml(data.message)}</div>
                        ${sampleHtml}
                    </div>`;
            } else {
                result.innerHTML = `
                    <div class="alert alert-danger border-0 shadow-sm mb-0">
                        <div class="fw-semibold"><i class="bi bi-x-circle-fill me-2"></i>Koneksi gagal</div>
                        <div class="small mt-1">${escapeHtml(data.message)}</div>
                    </div>`;
            }
        } catch (e) {
            result.innerHTML = `<div class="alert alert-danger border-0 shadow-sm mb-0">Error: ${escapeHtml(e.message)}</div>`;
        } finally {
            btn.disabled = false;
            btn.innerHTML = original;
        }
    });

    // ===== Login content: roles table (add/remove rows + icon preview) =====
    const rolesTbody = document.getElementById('rolesTbody');

    function newRoleRow(icon = 'bi-person', name = '', desc = '') {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white">
                        <i class="bi ${escapeHtml(icon)} role-icon-preview"></i>
                    </span>
                    <input type="text" name="login_roles_icon[]"
                           value="${escapeHtml(icon)}"
                           class="form-control form-control-sm role-icon-input"
                           placeholder="bi-person">
                </div>
            </td>
            <td><input type="text" name="login_roles_name[]" value="${escapeHtml(name)}" class="form-control form-control-sm" maxlength="50" placeholder="Admin"></td>
            <td><input type="text" name="login_roles_description[]" value="${escapeHtml(desc)}" class="form-control form-control-sm" maxlength="200" placeholder="Deskripsi singkat role"></td>
            <td class="text-end">
                <button type="button" class="btn btn-sm btn-outline-danger remove-role-btn" title="Hapus">
                    <i class="bi bi-trash"></i>
                </button>
            </td>`;
        return tr;
    }

    document.getElementById('addRoleBtn').addEventListener('click', function () {
        rolesTbody.appendChild(newRoleRow());
    });

    // Delegated handler: remove row + live update icon preview
    rolesTbody.addEventListener('click', function (e) {
        const rm = e.target.closest('.remove-role-btn');
        if (rm) {
            const tr = rm.closest('tr');
            if (tr) tr.remove();
        }
    });
    rolesTbody.addEventListener('input', function (e) {
        if (e.target.classList.contains('role-icon-input')) {
            const preview = e.target.closest('.input-group').querySelector('.role-icon-preview');
            if (preview) {
                preview.className = 'bi role-icon-preview';
                const cls = e.target.value.trim();
                if (cls) preview.classList.add(cls.startsWith('bi-') ? cls : ('bi-' + cls));
                else preview.classList.add('bi-person');
            }
        }
    });

    document.getElementById('fetchHeadersBtn').addEventListener('click', async function () {
        const btn = this;
        const result = document.getElementById('fetchHeadersResult');
        const original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Memuat...';
        result.innerHTML = '';

        const fd = new FormData();
        fd.append('api_key', pendaftaranApiKeyInput.value);
        fd.append('sheet_id', pendaftaranSheetIdInput.value);
        fd.append('range', document.getElementById('pendaftaranRangeInput').value);
        fd.append('_token', '{{ csrf_token() }}');

        try {
            const res = await fetch('{{ route('admin.settings.fetch-pendaftaran-headers') }}', {
                method: 'POST',
                body: fd,
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.ok && data.sample && data.sample.headers) {
                renderMappingTable(data.sample.headers);
                result.innerHTML = `<div class="alert alert-success border-0 shadow-sm mb-0 py-2 small">${escapeHtml(data.message)}</div>`;
            } else {
                result.innerHTML = `<div class="alert alert-danger border-0 shadow-sm mb-0 py-2 small">${escapeHtml(data.message || 'Gagal mengambil header.')}</div>`;
            }
        } catch (e) {
            result.innerHTML = `<div class="alert alert-danger border-0 shadow-sm mb-0 py-2 small">Error: ${escapeHtml(e.message)}</div>`;
        } finally {
            btn.disabled = false;
            btn.innerHTML = original;
        }
    });
});
</script>
@endpush
