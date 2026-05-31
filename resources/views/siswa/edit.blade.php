@extends('partials.master')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h1>Edit Data Siswa</h1>

                {{-- ===== Banner Kelengkapan Data (muncul saat datang dari halaman Kelengkapan) ===== --}}
                @isset($missingFields)
                    @if (count($missingFields))
                        <div id="kelengkapan-banner" class="alert alert-warning border-0 shadow-sm rounded-3 d-flex align-items-start gap-3 mb-3" role="alert">
                            <i class="bi bi-exclamation-triangle-fill fs-3 text-warning"></i>
                            <div class="flex-grow-1">
                                <div class="fw-semibold mb-1">
                                    Lengkapi {{ count($missingFields) }} field berikut:
                                </div>
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    @foreach ($missingFields as $mf)
                                        <button type="button"
                                                class="btn btn-sm btn-outline-warning rounded-pill px-3 missing-jump"
                                                data-field="{{ $mf }}">
                                            <i class="bi bi-arrow-down-circle me-1"></i>
                                            {{ $fieldLabels[$mf] ?? $mf }}
                                        </button>
                                    @endforeach
                                </div>
                                <small class="text-muted">Klik chip untuk meloncat ke field. Field bertanda merah belum diisi.</small>
                            </div>
                            <button type="button" class="btn-close" id="kelengkapan-banner-close" aria-label="Tutup"></button>
                        </div>

                        @push('styles')
                        <style>
                            .missing-highlight {
                                border-color: #f59e0b !important;
                                background-color: #fffbeb !important;
                                box-shadow: 0 0 0 0.18rem rgba(245, 158, 11, 0.18) !important;
                            }
                            .missing-flash {
                                animation: missingFlash 1.4s ease-out 1;
                            }
                            @keyframes missingFlash {
                                0%   { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.55); }
                                70%  { box-shadow: 0 0 0 12px rgba(245, 158, 11, 0); }
                                100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
                            }
                        </style>
                        @endpush

                        @push('scripts')
                        <script>
                            (function () {
                                const missingFields = @json($missingFields);

                                function findInputByName(name) {
                                    const sel = `input[name="${name}"], select[name="${name}"], textarea[name="${name}"], input[name="${name}[]"], select[name="${name}[]"]`;
                                    const els = document.querySelectorAll(sel);
                                    for (const el of els) {
                                        if (el.type === 'hidden') continue;
                                        if (el.offsetParent === null) continue; // display:none
                                        return el;
                                    }
                                    return els[0] || null;
                                }

                                // Auto-highlight
                                missingFields.forEach((name) => {
                                    const el = findInputByName(name);
                                    if (el) el.classList.add('missing-highlight');
                                });

                                // Klik chip → scroll & flash
                                document.querySelectorAll('.missing-jump').forEach((btn) => {
                                    btn.addEventListener('click', () => {
                                        const name = btn.getAttribute('data-field');
                                        const el = findInputByName(name);
                                        if (!el) return;

                                        // Buka accordion parent jika tertutup
                                        let p = el.closest('.accordion-collapse');
                                        if (p && !p.classList.contains('show')) {
                                            const id = p.getAttribute('id');
                                            const trigger = document.querySelector(`[data-bs-target="#${id}"]`);
                                            if (trigger) trigger.click();
                                            setTimeout(() => scrollAndFlash(el), 250);
                                        } else {
                                            scrollAndFlash(el);
                                        }
                                    });
                                });

                                function scrollAndFlash(el) {
                                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    el.classList.add('missing-flash');
                                    try { el.focus({ preventScroll: true }); } catch (e) {}
                                    setTimeout(() => el.classList.remove('missing-flash'), 1500);
                                }

                                // Close banner
                                const closeBtn = document.getElementById('kelengkapan-banner-close');
                                if (closeBtn) {
                                    closeBtn.addEventListener('click', () => {
                                        document.getElementById('kelengkapan-banner').remove();
                                        document.querySelectorAll('.missing-highlight').forEach(el => el.classList.remove('missing-highlight'));
                                    });
                                }
                            })();
                        </script>
                        @endpush
                    @endif
                @endisset

                <div class="card card-info card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">Formm edit Siswa</div>
                    </div>
                    <form
                        method="POST"
                        action="{{ route('siswa.update', $datasiswa->id) }}"
                    >
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row g-3">
                                {{-- TES ACCORDION --}}
                                <div
                                    class="accordion"
                                    id="accordionPanelsStayOpenExample"
                                >
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseOne"
                                                aria-expanded="true"
                                                aria-controls="panelsStayOpen-collapseOne"
                                            >
                                                <strong>
                                                    Data Siswa Baru
                                                </strong>

                                            </button>
                                        </h2>
                                        <div
                                            id="panelsStayOpen-collapseOne"
                                            class="accordion-collapse collapse show"
                                        >
                                            <div class="accordion-body">

                                                {{-- input data siswa --}}

                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class ="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="namasiswa"
                                                            >Nama</label>
                                                            <input
                                                                value="{{ old('namasiswa', $datasiswa->namasiswa) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="Nama Siswa"
                                                                name="namasiswa"
                                                                required
                                                            />
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-3">
                                                            <label
                                                                for="validationCustom03"
                                                                class="form-label"
                                                            >Jurusan</label>

                                                            <select
                                                                name="jurusan"
                                                                class="form-select"
                                                                required
                                                            >
                                                                <option selected>{{ old('jurusan', $datasiswa->jurusan) }}
                                                                </option>
                                                                <option
                                                                    value="Teknik Komputer Jaringan"
                                                                    {{ old('jurusan', $datasiswa->jurusan) == 'Teknik Komputer Jaringan' ? 'selected' : '' }}
                                                                >Teknik Komputer Jaringan</option>
                                                                <option
                                                                    value="Teknik Sepeda Motor"
                                                                    {{ old('jurusan', $datasiswa->jurusan) == 'Teknik Sepeda Motor' ? 'selected' : '' }}
                                                                >Teknik Sepeda Motor</option>

                                                            </select>
                                                            <div class="invalid-feedback">Pilih Jurusan</div>
                                                        </div>

                                                        {{-- JALUR PRESTASI --}}

                                                        <div class="col-md-3">
                                                            <label
                                                                for="validationCustom03"
                                                                class="form-label"
                                                            >Jalur Pendaftaran</label>
                                                            <select
                                                                name="jalurdaftar"
                                                                class="form-select"
                                                                required
                                                            >
                                                                <option selected>
                                                                    {{ old('jalurdaftar', $datasiswa->jalurdaftar) }}
                                                                </option>
                                                                <option
                                                                    value="Reguler"
                                                                    {{ old('jalurdaftar', $datasiswa->jalurdaftar) == 'Reguler' ? 'selected' : '' }}
                                                                >Reguler</option>
                                                                <option
                                                                    value="Prestasi"
                                                                    {{ old('jalurdaftar', $datasiswa->jalurdaftar) == 'Prestasi' ? 'selected' : '' }}
                                                                >Prestasi</option>
                                                            </select>
                                                            <div class="invalid-feedback">Masukan Jalur Pendaftaran</div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="sekolah_asal"
                                                                class="form-label"
                                                            >Sekolah Asal</label>
                                                            @php
                                                                $currentSekolah = old('sekolah_asal', $datasiswa->sekolah_asal);
                                                                $isInList = $currentSekolah && $sekolahList->contains($currentSekolah);
                                                                $useManual = $currentSekolah && !$isInList;
                                                            @endphp
                                                            <select
                                                                class="form-select"
                                                                id="sekolah_asal"
                                                                name="sekolah_asal"
                                                                onchange="toggleSekolahAsalManual(this)"
                                                            >
                                                                <option value="">-- Pilih sekolah asal --</option>
                                                                @foreach ($sekolahList as $sekolah)
                                                                    <option
                                                                        value="{{ $sekolah }}"
                                                                        @selected($isInList && $sekolah === $currentSekolah)
                                                                    >{{ $sekolah }}</option>
                                                                @endforeach
                                                                <option
                                                                    value="__OTHER__"
                                                                    @selected($useManual)
                                                                >Lainnya (tulis manual)</option>
                                                            </select>
                                                            <input
                                                                type="text"
                                                                class="form-control mt-2 {{ $useManual ? '' : 'd-none' }}"
                                                                id="sekolah_asal_other"
                                                                name="sekolah_asal_other"
                                                                placeholder="Tulis nama sekolah asal"
                                                                value="{{ $useManual ? $currentSekolah : '' }}"
                                                            >
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-3">
                                                            <label
                                                                for="validationCustom03"
                                                                class="form-label"
                                                            >Gender</label>
                                                            <select
                                                                name="jeniskelamin"
                                                                class="form-select"
                                                                required
                                                            >
                                                                <option selected>
                                                                    {{ old('jeniskelamin', $datasiswa->jeniskelamin) }}
                                                                </option>
                                                                <option
                                                                    value="Laki-laki"
                                                                    {{ old('jeniskelamin', $datasiswa->jeniskelamin) == 'Laki-laki' ? 'selected' : '' }}
                                                                >Laki-laki</option>
                                                                <option
                                                                    value="Perempuan"
                                                                    {{ old('jeniskelamin', $datasiswa->jeniskelamin) == 'Perempuan' ? 'selected' : '' }}
                                                                >Perempuan</option>
                                                            </select>
                                                            <div class="invalid-feedback">Masukan Gender</div>
                                                        </div>


                                                        <div class="col-md-3">
                                                            <label
                                                                for="asrama_tahfidz"
                                                                class="form-label"
                                                            >Asrama Tahfidz</label>
                                                            <select
                                                                name="asrama_tahfidz"
                                                                class="form-select"
                                                                required
                                                            >
                                                                <option selected>
                                                                    {{ old('asrama_tahfidz', $datasiswa->asrama_tahfidz) }}

                                                                </option>
                                                                <option
                                                                    value="Bersedia"
                                                                    {{ old('asrama_tahfidz', $datasiswa->asrama_tahfidz) == 'Bersedia' ? 'selected' : '' }}
                                                                >Bersedia</option>
                                                                <option
                                                                    value="Tidak"
                                                                    {{ old('asrama_tahfidz', $datasiswa->asrama_tahfidz) == 'Tidak' ? 'selected' : '' }}
                                                                >Tidak</option>
                                                            </select>
                                                            <div class="invalid-feedback">Pilih status asrama tahfidz</div>
                                                        </div>

                                                        {{-- batas --}}


                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="tempatlahir"
                                                            >Tempat Lahir</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('tempatlahir', $datasiswa->tempatlahir) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tempat Lahir"
                                                                    name="tempatlahir"
                                                                />
                                                                <div class="invalid-feedback">Tempat Lahir</div>
                                                            </div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                            >Tanggal Lahir</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('tanggallahir', $datasiswa->tanggallahir) }}"
                                                                    type="date"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tanggal Lahir"
                                                                    name="tanggallahir"
                                                                />
                                                                <div class="invalid-feedback">Tanggal Lahir</div>
                                                            </div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="alamat"
                                                            >Alamat</label>
                                                            <div class="input-group has-validation">
                                                                <textarea
                                                                    type="textarea"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Alamat"
                                                                    name="alamat"
                                                                >{{ old('alamat', $datasiswa->alamat) }}</textarea>
                                                                <div class="invalid-feedback">Tulis Alamat</div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-3">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="beratbadan"
                                                            >Berat Badan</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('beratbadan', $datasiswa->beratbadan) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Berat Badan"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    name="beratbadan"
                                                                />
                                                                <div class="invalid-feedback">Berat Badan</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="tinggibadan"
                                                            >Tinggi Badan</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('tinggibadan', $datasiswa->tinggibadan) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tinggi Badan"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    name="tinggibadan"
                                                                />
                                                                <div class="invalid-feedback">Tinggi Badan</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="lingkar_kepala"
                                                            >Lingkar Kepala</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('lingkar_kepala', $datasiswa->lingkar_kepala) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Lingkar Kepala (cm)"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    name="lingkar_kepala"
                                                                />
                                                                <div class="invalid-feedback">Lingkar Kepala</div>
                                                            </div>
                                                        </div>








                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nis"
                                                            >NIS</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nis', $datasiswa->nis) }}"
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis NIS"
                                                                    name="nis"
                                                                />
                                                                <div class="invalid-feedback">Tulis NIS</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nisn"
                                                            >NISN</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nisn', $datasiswa->nisn) }}"
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis NISN"
                                                                    name="nisn"
                                                                />
                                                                <div class="invalid-feedback">Tulis NISN</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nomorsiswa"
                                                            >Nomor HP siswa</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nomorsiswa', $datasiswa->nomorsiswa) }}"
                                                                    type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    min="0"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nomor HP Siswa"
                                                                    name="nomorsiswa"
                                                                />
                                                                <div class="invalid-feedback">Nomor HP Siswa</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="email"
                                                            >Email</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('email', $datasiswa->email) }}"
                                                                    type="email"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Email"
                                                                    name="email"
                                                                />
                                                                <div class="invalid-feedback">Email</div>
                                                            </div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="tahunmasuk"
                                                            >Tahun Masuk</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('tahunmasuk', $datasiswa->tahunmasuk) }}"
                                                                    type="number"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tahun Masuk"
                                                                    max="2050"
                                                                    min="2008"
                                                                    name="tahunmasuk"
                                                                />
                                                                <div class="invalid-feedback">Tahun Masuk</div>
                                                            </div>
                                                        </div>



                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="agama"
                                                            >Agama</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('agama', $datasiswa->agama) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    value= "Islam"
                                                                    placeholder="Tulis Agama"
                                                                    name="agama"
                                                                />
                                                                <div class="invalid-feedback">Tulis Agama</div>
                                                            </div>
                                                        </div>







                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="transport"
                                                            >transport</label>
                                                            <input
                                                                value="{{ old('transport', $datasiswa->transport) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="transport"
                                                                name="transport"
                                                            />
                                                        </div>



                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom03"
                                                                class="form-label"
                                                            >Kebutuhan Khusus</label>

                                                            <select
                                                                name="kebutuhan_khusus"
                                                                class="form-select"
                                                                required
                                                            >
                                                                <option selected>
                                                                    {{ old('kebutuhan_khusus', $datasiswa->kebutuhan_khusus) }}
                                                                </option>
                                                                <option
                                                                    value="Ya"
                                                                    {{ old('kebutuhan_khusus', $datasiswa->kebutuhan_khusus) == 'Ya' ? 'selected' : '' }}
                                                                >Ya</option>
                                                                <option
                                                                    value="Tidak"
                                                                    {{ old('kebutuhan_khusus', $datasiswa->kebutuhan_khusus) == 'Tidak' ? 'selected' : '' }}
                                                                >Tidak</option>
                                                            </select>
                                                            <div class="invalid-feedback">Masukan kebutuhan_khusus
                                                            </div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="jenis_tinggal"
                                                            >Jenis tinggal</label>
                                                            <input
                                                                value="{{ old('jenis_tinggal', $datasiswa->jenis_tinggal) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="jenis_tinggal"
                                                                name="jenis_tinggal"
                                                            />
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="jumlah_saudara"
                                                            >Jumlah Saudara</label>
                                                            <input
                                                                value="{{ old('jumlah_saudara', $datasiswa->jumlah_saudara) }}"
                                                                type="text"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="jumlah_saudara"
                                                                name="jumlah_saudara"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- batas --}}

                                            </div>
                                        </div>
                                    </div>



                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseTwo"
                                                aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseTwo"
                                            >
                                                <strong>
                                                    Data Dokumen
                                                </strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="panelsStayOpen-collapseTwo"
                                            class="accordion-collapse collapse"
                                        >
                                            <div class="accordion-body">
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nomorkip"
                                                            >Nomor KIP</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nomorkip', $datasiswa->nomorkip) }}"
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis nomorkip"
                                                                    name="nomorkip"
                                                                />
                                                                <div class="invalid-feedback">Tulis nomor KIP</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nomorkks"
                                                            >Nomor KKS</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nomorkks', $datasiswa->nomorkks) }}"
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis nomorkks"
                                                                    name="nomorkks"
                                                                />
                                                                <div class="invalid-feedback">Tulis Nomor KKS</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nomorkps"
                                                            >Nomor KPS</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nomorkps', $datasiswa->nomorkps) }}"
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis nomorkps"
                                                                    name="nomorkps"
                                                                />
                                                                <div class="invalid-feedback">Tulis Nomor KPS</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="akta_lahir"
                                                            >Akta Lahir</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('akta_lahir', $datasiswa->akta_lahir) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis akta_lahir"
                                                                    name="akta_lahir"
                                                                />
                                                                <div class="invalid-feedback">Akta Lahir</div>
                                                            </div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nik"
                                                            >NIK</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nik', $datasiswa->nik) }}"
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis NIK"
                                                                    name="nik"
                                                                />
                                                                <div class="invalid-feedback">Tulis NIK</div>
                                                            </div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="kartu_keluarga"
                                                            >Kartu Keluarga</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('kartu_keluarga', $datasiswa->kartu_keluarga) }}"
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tulis kartu_keluarga"
                                                                    name="kartu_keluarga"
                                                                />
                                                                <div class="invalid-feedback">Kartu Keluarga</div>
                                                            </div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="npsn"
                                                            >NPSN</label>
                                                            <input
                                                                value="{{ old('npsn', $datasiswa->npsn) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="NPSN"
                                                                name="npsn"
                                                            />
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="ijazah"
                                                            >Ijazah</label>
                                                            <input
                                                                value="{{ old('ijazah', $datasiswa->ijazah) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="Ijazah"
                                                                name="ijazah"
                                                            />
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="skhun"
                                                            >SKHUN</label>
                                                            <input
                                                                value="{{ old('skhun', $datasiswa->skhun) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="skhun"
                                                                name="skhun"
                                                            />
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="nomor_ujian_nasional"
                                                            >Nomor Ujian Nasional</label>
                                                            <input
                                                                value="{{ old('nomor_ujian_nasional', $datasiswa->nomor_ujian_nasional) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="nomor_ujian_nasional"
                                                                name="nomor_ujian_nasional"
                                                            />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseThree"
                                                aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseThree"
                                            >
                                                <strong>
                                                    Data Ayah
                                                </strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="panelsStayOpen-collapseThree"
                                            class="accordion-collapse collapse"
                                        >
                                            <div class="accordion-body">
                                                <div class="card-body">
                                                    <div class="row g-3">

                                                        {{-- ayah --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="nama_ayah"
                                                            >Nama Ayah</label>
                                                            <input
                                                                value="{{ old('nama_ayah', $datasiswa->nama_ayah) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="nama_ayah"
                                                                name="nama_ayah"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="pendidikan_ayah"
                                                            >Pendidikan Ayah</label>
                                                            <input
                                                                value="{{ old('pendidikan_ayah', $datasiswa->pendidikan_ayah) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="pendidikan_ayah"
                                                                name="pendidikan_ayah"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="tempat_lahir_ayah"
                                                            >Tempat Lahir Ayah</label>
                                                            <input
                                                                value="{{ old('tempat_lahir_ayah', $datasiswa->tempat_lahir_ayah) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="tempat_lahir_ayah"
                                                                name="tempat_lahir_ayah"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="tanggal_lahir_ayah"
                                                            >Tanggal Lahir Ayah</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('tanggal_lahir_ayah', $datasiswa->tanggal_lahir_ayah) }}"
                                                                    type="date"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="tanggal_lahir_ayah"
                                                                    name="tanggal_lahir_ayah"
                                                                />
                                                                <div class="invalid-feedback">Tanggal Lahir Ayah</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="alamat_ayah"
                                                            >alamat_ayah</label>
                                                            <div class="input-group has-validation">
                                                                <textarea
                                                                    type="textarea"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="alamat_ayah"
                                                                    name="alamat_ayah"
                                                                >{{ old('alamat_ayah', $datasiswa->alamat_ayah) }}</textarea>
                                                                <div class="invalid-feedback">Tulis alamat_ayah</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="pekerjaan_ayah"
                                                            >pekerjaan_ayah</label>
                                                            <input
                                                                value="{{ old('pekerjaan_ayah', $datasiswa->pekerjaan_ayah) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="pekerjaan_ayah"
                                                                name="pekerjaan_ayah"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="penghasilan_ayah"
                                                            >penghasilan_ayah</label>
                                                            <input
                                                                value="{{ old('penghasilan_ayah', $datasiswa->penghasilan_ayah) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="penghasilan_ayah"
                                                                name="penghasilan_ayah"
                                                            />
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nomor_ayah"
                                                            >Nomor HP Ayah</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nomor_ayah', $datasiswa->nomor_ayah) }}"
                                                                    type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    min="0"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nomor HP Siswa"
                                                                    name="nomor_ayah"
                                                                />
                                                                <div class="invalid-feedback">Nomor HP Ayah zaaa</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseFour"
                                                aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseFour"
                                            >
                                                <strong>
                                                    Data Ibu
                                                </strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="panelsStayOpen-collapseFour"
                                            class="accordion-collapse collapse"
                                        >
                                            <div class="accordion-body">
                                                <div class="card-body">
                                                    <div class="row g-3">

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="nama_ibu"
                                                            >nama ibu</label>
                                                            <input
                                                                value="{{ old('nama_ibu', $datasiswa->nama_ibu) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="nama ibu"
                                                                name="nama_ibu"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="pendidikan_ibu"
                                                            >pendidikan ibu</label>
                                                            <input
                                                                value="{{ old('pendidikan_ibu', $datasiswa->pendidikan_ibu) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="pendidikan ibu"
                                                                name="pendidikan_ibu"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="tempat_lahir_ibu"
                                                            >tempat lahir ibu</label>
                                                            <input
                                                                value="{{ old('tempat_lahir_ibu', $datasiswa->tempat_lahir_ibu) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="tempat lahir ibu"
                                                                name="tempat_lahir_ibu"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="tanggal_lahir_ibu"
                                                            >tanggal lahir ibu</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('tanggal_lahir_ibu', $datasiswa->tanggal_lahir_ibu) }}"
                                                                    type="date"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="tanggal lahir ibu"
                                                                    name="tanggal_lahir_ibu"
                                                                />
                                                                <div class="invalid-feedback">tanggal lahir ibu</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class=     "col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="alamat_ibu"
                                                            >alamat ibu</label>
                                                            <div class="input-group has-validation">
                                                                <textarea
                                                                    type="textarea"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="alamat ibu"
                                                                    name="alamat_ibu"
                                                                >{{ old('alamat_ibu', $datasiswa->alamat_ibu) }}</textarea>
                                                                <div class="invalid-feedback">Tulis alamat ibu</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="pekerjaan_ibu"
                                                            >pekerjaan ibu</label>
                                                            <input
                                                                value="{{ old('pekerjaan_ibu', $datasiswa->pekerjaan_ibu) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="pekerjaan ibu"
                                                                name="pekerjaan_ibu"
                                                            />
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="penghasilan_ibu"
                                                            >penghasilan ibu</label>
                                                            <input
                                                                value="{{ old('penghasilan_ibu', $datasiswa->penghasilan_ibu) }}"
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="penghasilan ibu"
                                                                name="penghasilan_ibu"
                                                            />
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nomor_ibu"
                                                            >Nomor HP ibu</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nomor_ibu', $datasiswa->nomor_ibu) }}"
                                                                    type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    min="0"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nomor HP Ibu"
                                                                    name="nomor_ibu"
                                                                />
                                                                <div class="invalid-feedback">Nomor HP ibu zaaa</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button
                                                class="accordion-button collapsed"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseFive"
                                                aria-expanded="false"
                                                aria-controls="panelsStayOpen-collapseFive"
                                            >
                                                <strong>
                                                    Data Wali
                                                </strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="panelsStayOpen-collapseFive"
                                            class="accordion-collapse collapse"
                                        >
                                            <div class="accordion-body">
                                                <div class="card-body">
                                                    <div class="row g-3">



                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nama_wali"
                                                            >Nama Wali</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nama_wali', $datasiswa->nama_wali) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nama Wali"
                                                                    name="nama_wali"
                                                                />
                                                                <div class="invalid-feedback">Nama Wali</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="alamat_wali"
                                                            >Alamat Wali</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('alamat_wali', $datasiswa->alamat_wali) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nama Wali"
                                                                    name="alamat_wali"
                                                                />
                                                                <div class="invalid-feedback">Alamat Wali</div>
                                                            </div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="penghasilan_wali"
                                                            >penghasilan_wali</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('penghasilan_wali', $datasiswa->penghasilan_wali) }}"
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nama Wali"
                                                                    name="penghasilan_wali"
                                                                />
                                                                <div class="invalid-feedback">penghasilan_wali</div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustomUsername"
                                                                class="form-label"
                                                                name="nomor_wali"
                                                            >Nomor HP Wali</label>
                                                            <div class="input-group has-validation">
                                                                <input
                                                                    value="{{ old('nomor_wali', $datasiswa->nomor_wali) }}"
                                                                    type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    min="0"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nomor HP Wali"
                                                                    name="nomor_wali"
                                                                />
                                                                <div class="invalid-feedback">Nomor HP Wali</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row g-3">
                                    {{-- <div class="card-footer"> --}}
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >Submit form</button>
                                    {{-- </div> --}}
                                </div>
                            </div>
                    </form>


                    <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (() => {
                            'use strict';

                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            const forms = document.querySelectorAll('.needs-validation');

                            // Loop over them and prevent submission
                            Array.from(forms).forEach((form) => {
                                form.addEventListener(
                                    'submit',
                                    (event) => {
                                        if (!form.checkValidity()) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }

                                        form.classList.add('was-validated');
                                    },
                                    false,
                                );
                            });
                        })();

                        function toggleSekolahAsalManual(selectEl) {
                            const manualInput = document.getElementById('sekolah_asal_other');
                            if (selectEl.value === '__OTHER__') {
                                manualInput.classList.remove('d-none');
                                manualInput.required = true;
                                manualInput.focus();
                            } else {
                                manualInput.classList.add('d-none');
                                manualInput.required = false;
                                manualInput.value = '';
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </main>
@endsection
