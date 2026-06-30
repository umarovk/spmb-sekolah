@extends('partials.master')

@section('isihome')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-primary bg-opacity-10 py-3 border-0">
                        <h4 class="card-title mb-0 text-primary">
                            <i class="bi bi-download me-2"></i>Export Data Siswa
                        </h4>
                        <small class="text-muted d-block mt-1">Pilih field yang ingin didownload dalam format CSV</small>
                    </div>
                    <div class="card-body">
                        <form id="exportForm" method="POST" action="{{ route('siswa.export') }}">
                            @csrf

                            <!-- Select All / Deselect All Buttons -->
                            <div class="mb-4">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllBtn">
                                        <i class="bi bi-check2-all me-1"></i>Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllBtn">
                                        <i class="bi bi-x-circle me-1"></i>Hapus Pilihan
                                    </button>
                                </div>
                            </div>

                            <!-- Fields Container -->
                            <div class="row g-3" id="fieldsContainer">
                                <!-- Fields will be loaded here -->
                                <div class="col-12 text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="text-muted mt-2">Memuat data field...</p>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-5 d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-download me-2"></i>Download CSV
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Field groups for better UI organization
        const fieldGroups = {
            'Data Dasar': ['no', 'namasiswa', 'jurusan', 'jalurdaftar', 'jeniskelamin', 'agama', 'email'],
            'Informasi Pribadi': ['tempatlahir', 'tanggallahir', 'nik', 'nisn', 'nis', 'nomorsiswa', 'kebutuhan_khusus'],
            'Identitas Tambahan': ['nomorkip', 'nomorkps', 'nomorkks', 'akta_lahir', 'kartu_keluarga'],
            'Pendidikan': ['sekolah_asal', 'npsn', 'tahun_lulus_smp', 'ijazah', 'skhun', 'nomor_ujian_nasional'],
            'Alamat & Kontak': ['alamat', 'nomorsiswa_kontak', 'transport', 'jenis_tinggal'],
            'Data Fisik': ['tinggibadan', 'beratbadan', 'lingkar_kepala'],
            'Keluarga': ['jumlah_saudara', 'anak_ke', 'cita_cita', 'hobi'],
            'Data Ayah': ['nama_ayah', 'pendidikan_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah', 'alamat_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'nomor_ayah'],
            'Data Ibu': ['nama_ibu', 'pendidikan_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu', 'alamat_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'nomor_ibu'],
            'Data Wali': ['nama_wali', 'alamat_wali', 'nomor_wali', 'penghasilan_wali'],
            'Status & Pembayaran': ['status_seleksi', 'tanggalseleksi', 'status_pembayaran', 'asrama_tahfidz'],
            'Tanggal': ['tanggal_pendaftaran']
        };

        // Fields yang di-default checked
        const defaultCheckedFields = [
            'no', 'namasiswa', 'jurusan', 'jalurdaftar', 'jeniskelamin', 'agama',
            'status_seleksi', 'status_pembayaran', 'nomorsiswa_kontak', 'email',
            'tanggal_pendaftaran'
        ];

        document.addEventListener('DOMContentLoaded', function() {
            loadExportFields();
        });

        function loadExportFields() {
            const container = document.getElementById('fieldsContainer');

            fetch('{{ route("siswa.export-fields") }}')
                .then(response => response.json())
                .then(fields => {
                    let html = '';

                    for (const [group, fieldKeys] of Object.entries(fieldGroups)) {
                        html += `
                            <div class="col-12">
                                <h6 class="text-primary fw-bold mb-3 mt-2">
                                    <i class="bi bi-folder me-1"></i>${group}
                                </h6>
                                <div class="row g-2">
                        `;

                        let groupHtml = '';
                        fieldKeys.forEach(fieldKey => {
                            if (fields[fieldKey]) {
                                const field = fields[fieldKey];
                                const isChecked = defaultCheckedFields.includes(fieldKey) ? 'checked' : '';

                                groupHtml += `
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-check">
                                            <input class="form-check-input field-checkbox" type="checkbox"
                                                   name="fields[]" value="${fieldKey}" id="field_${fieldKey}" ${isChecked}>
                                            <label class="form-check-label" for="field_${fieldKey}">
                                                ${field.label}
                                            </label>
                                        </div>
                                    </div>
                                `;
                            }
                        });

                        html += groupHtml + `
                                </div>
                            </div>
                        `;
                    }

                    container.innerHTML = html;
                    attachCheckboxListeners();
                })
                .catch(error => {
                    console.error('Error loading fields:', error);
                    container.innerHTML = '<div class="col-12"><div class="alert alert-danger">Gagal memuat data field</div></div>';
                });
        }

        function attachCheckboxListeners() {
            const selectAllBtn = document.getElementById('selectAllBtn');
            const deselectAllBtn = document.getElementById('deselectAllBtn');

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('.field-checkbox').forEach(cb => cb.checked = true);
                });
            }

            if (deselectAllBtn) {
                deselectAllBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('.field-checkbox').forEach(cb => cb.checked = false);
                });
            }
        }
    </script>
@endpush
