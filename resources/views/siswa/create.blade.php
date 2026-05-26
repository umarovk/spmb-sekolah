@extends('partials.master')

@section('isisiswa')
    <main class="app-main">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-white py-3">
                            <h3 class="text-center font-weight-light my-2">Tambah Data Siswa</h3>
                        </div>
                        <div class="card-body">
                            @if (!empty($gformConfigured))
                                <div class="mb-4 position-relative">
                                    <label for="gformSearch" class="form-label fw-semibold">
                                        <i class="bi bi-search me-1"></i> Cari Data dari Google Form Pendaftaran
                                    </label>
                                    <input
                                        type="text"
                                        id="gformSearch"
                                        class="form-control"
                                        placeholder="Ketik nama siswa minimal 2 huruf..."
                                        autocomplete="off"
                                    >
                                    <div
                                        id="gformResults"
                                        class="list-group position-absolute w-100 shadow"
                                        style="display:none;z-index:1000;max-height:280px;overflow-y:auto;"
                                    ></div>
                                    <small class="text-muted">Klik salah satu hasil untuk autofill form di bawah.</small>
                                </div>
                            @endif

                            <form
                                method="POST"
                                action="{{ route('siswa.store') }}"
                                class="needs-validation"
                                novalidate
                            >
                                @csrf

                                <!-- Accordion Start -->
                                <div
                                    class="accordion mb-4"
                                    id="studentFormAccordion"
                                >
                                    <!-- Data Siswa Accordion -->
                                    <div class="accordion-item border-0 mb-3 shadow-sm">
                                        <h2
                                            class="accordion-header"
                                            id="dataSiswaHeading"
                                        >
                                            <button
                                                class="accordion-button rounded-3"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#dataSiswaCollapse"
                                                aria-expanded="true"
                                                aria-controls="dataSiswaCollapse"
                                            >
                                                <i class="bi bi-person-fill me-2"></i> <strong>Data Siswa Baru</strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="dataSiswaCollapse"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="dataSiswaHeading"
                                        >
                                            <div class="accordion-body">
                                                <div class="row g-3">
                                                    <!-- Nama -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="namasiswa"
                                                            class="form-label"
                                                        >Nama Lengkap</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="namasiswa"
                                                            placeholder="Masukkan nama lengkap"
                                                            name="namasiswa"
                                                            required
                                                        >
                                                        <div class="invalid-feedback">Nama tidak boleh kosong</div>
                                                    </div>

                                                    <!-- Jurusan -->
                                                    <div class="col-md-3">
                                                        <label
                                                            for="jurusan"
                                                            class="form-label"
                                                        >Jurusan</label>
                                                        <select
                                                            name="jurusan"
                                                            class="form-select"
                                                            id="jurusan"
                                                            required
                                                        >
                                                            <option value="">Pilih Jurusan</option>
                                                            <option value="Teknik Sepeda Motor">Teknik Sepeda Motor</option>
                                                            <option value="Teknik Komputer Jaringan">Teknik Komputer
                                                                Jaringan</option>
                                                        </select>
                                                        <div class="invalid-feedback">Pilih jurusan</div>
                                                    </div>

                                                    <!-- Gender -->
                                                    <div class="col-md-3">
                                                        <label
                                                            for="jalurdaftar"
                                                            class="form-label"
                                                        >Jalur Pendaftaran</label>
                                                        <select
                                                            name="jalurdaftar"
                                                            class="form-select"
                                                            id="jalurdaftar"
                                                            required
                                                        >
                                                            <option value="">Pilih Jalur</option>
                                                            <option value="Reguler">Reguler</option>
                                                            <option value="Prestasi">Prestasi</option>
                                                        </select>
                                                        <div class="invalid-feedback">Pilih Jalur Prestasi</div>
                                                    </div>

                                                    <!-- Sekolah Asal -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="sekolah_asal"
                                                            class="form-label"
                                                        >Sekolah Asal</label>
                                                        <select
                                                            class="form-select"
                                                            id="sekolah_asal"
                                                            name="sekolah_asal"
                                                            required
                                                            onchange="toggleSekolahAsalManual(this)"
                                                        >
                                                            <option value="">-- Pilih sekolah asal --</option>
                                                            @foreach ($sekolahList as $sekolah)
                                                                <option value="{{ $sekolah }}">{{ $sekolah }}</option>
                                                            @endforeach
                                                            <option value="__OTHER__">Lainnya (tulis manual)</option>
                                                        </select>
                                                        <input
                                                            type="text"
                                                            class="form-control mt-2 d-none"
                                                            id="sekolah_asal_other"
                                                            name="sekolah_asal_other"
                                                            placeholder="Tulis nama sekolah asal"
                                                        >
                                                        <div class="invalid-feedback">Sekolah asal tidak boleh kosong</div>
                                                    </div>

                                                    <!-- Gender -->
                                                    <div class="col-md-3">
                                                        <label
                                                            for="jeniskelamin"
                                                            class="form-label"
                                                        >Jenis Kelamin</label>
                                                        <select
                                                            name="jeniskelamin"
                                                            class="form-select"
                                                            id="jeniskelamin"
                                                            required
                                                        >
                                                            <option value="">Pilih</option>
                                                            <option value="Laki-laki">Laki-laki</option>
                                                            <option value="Perempuan">Perempuan</option>
                                                        </select>
                                                        <div class="invalid-feedback">Pilih jenis kelamin</div>
                                                    </div>

                                                    <!-- Asrama Tahfidz -->
                                                    <div class="col-md-3">
                                                        <label
                                                            for="asrama_tahfidz"
                                                            class="form-label"
                                                        >Asrama Tahfidz</label>
                                                        <select
                                                            name="asrama_tahfidz"
                                                            class="form-select"
                                                            id="asrama_tahfidz"
                                                            required
                                                        >
                                                            <option value="">Pilih</option>
                                                            <option value="Bersedia">Bersedia</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                        <div class="invalid-feedback">Pilih status asrama</div>
                                                    </div>

                                                    <!-- Tempat Lahir -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="tempatlahir"
                                                            class="form-label"
                                                        >Tempat Lahir</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="tempatlahir"
                                                            placeholder="Masukkan tempat lahir"
                                                            name="tempatlahir"
                                                            required
                                                        >
                                                        <div class="invalid-feedback">Tempat lahir tidak boleh kosong</div>
                                                    </div>

                                                    <!-- Tanggal Lahir -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="tanggallahir"
                                                            class="form-label"
                                                        >Tanggal Lahir</label>
                                                        <input
                                                            type="date"
                                                            class="form-control"
                                                            id="tanggallahir"
                                                            name="tanggallahir"
                                                            required
                                                        >
                                                        <div class="invalid-feedback">Pilih tanggal lahir</div>
                                                    </div>

                                                    <!-- Alamat -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="alamat"
                                                            class="form-label"
                                                        >Alamat</label>
                                                        <textarea
                                                            class="form-control"
                                                            id="alamat"
                                                            name="alamat"
                                                            placeholder="Masukkan alamat lengkap"
                                                            rows="3"
                                                        ></textarea>
                                                    </div>

                                                    <!-- Nomor HP -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nomorsiswa"
                                                            class="form-label"
                                                        >Nomor HP Siswa</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nomorsiswa"
                                                            placeholder="Contoh: 08xxxxxxxxxx"
                                                            name="nomorsiswa"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                            required
                                                        >
                                                        <div class="invalid-feedback">Nomor HP tidak boleh kosong</div>
                                                    </div>

                                                    <!-- Berat & Tinggi Badan -->
                                                    <div class="col-md-3">
                                                        <label
                                                            for="beratbadan"
                                                            class="form-label"
                                                        >Berat Badan (kg)</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="beratbadan"
                                                            placeholder="Contoh: 60"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                            name="beratbadan"
                                                        >
                                                    </div>

                                                    <div class="col-md-3">
                                                        <label
                                                            for="tinggibadan"
                                                            class="form-label"
                                                        >Tinggi Badan (cm)</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="tinggibadan"
                                                            placeholder="Contoh: 170"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                            name="tinggibadan"
                                                        >
                                                    </div>

                                                    <!-- NIS -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nis"
                                                            class="form-label"
                                                        >NIS</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nis"
                                                            placeholder="Masukkan NIS"
                                                            name="nis"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        >
                                                    </div>

                                                    <!-- NISN -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nisn"
                                                            class="form-label"
                                                        >NISN</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nisn"
                                                            placeholder="Masukkan NISN"
                                                            name="nisn"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        >
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="email"
                                                            class="form-label"
                                                        >Email</label>
                                                        <input
                                                            type="email"
                                                            class="form-control"
                                                            id="email"
                                                            placeholder="Contoh: nama@email.com"
                                                            name="email"
                                                        >
                                                    </div>

                                                    <!-- Tahun Masuk -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="tahunmasuk"
                                                            class="form-label"
                                                        >Tahun Masuk</label>
                                                        <input
                                                            type="number"
                                                            class="form-control"
                                                            id="tahunmasuk"
                                                            placeholder="Contoh: 2023"
                                                            name="tahunmasuk"
                                                            min="2008"
                                                            max="2050"
                                                        >
                                                    </div>

                                                    <!-- Agama -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="agama"
                                                            class="form-label"
                                                        >Agama</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="agama"
                                                            value="Islam"
                                                            name="agama"
                                                        >
                                                    </div>

                                                    <!-- Transport -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="transport"
                                                            class="form-label"
                                                        >Transportasi</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="transport"
                                                            placeholder="Contoh: Motor, Angkutan Umum"
                                                            name="transport"
                                                        >
                                                    </div>

                                                    <!-- Kebutuhan Khusus -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="kebutuhan_khusus"
                                                            class="form-label"
                                                        >Kebutuhan Khusus</label>
                                                        <select
                                                            name="kebutuhan_khusus"
                                                            class="form-select"
                                                            id="kebutuhan_khusus"
                                                        >
                                                            <option value="-">-</option>
                                                            <option value="Ya">Ya</option>
                                                            <option value="Tidak">Tidak</option>
                                                        </select>
                                                    </div>

                                                    <!-- Jenis Tinggal -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="jenis_tinggal"
                                                            class="form-label"
                                                        >Jenis Tinggal</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="jenis_tinggal"
                                                            placeholder="Contoh: Rumah Sendiri, Kos"
                                                            name="jenis_tinggal"
                                                        >
                                                    </div>

                                                    <!-- Jumlah Saudara -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="jumlah_saudara"
                                                            class="form-label"
                                                        >Jumlah Saudara</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="jumlah_saudara"
                                                            placeholder="Masukkan jumlah saudara"
                                                            name="jumlah_saudara"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Data Dokumen Accordion -->
                                    <div class="accordion-item border-0 mb-3 shadow-sm">
                                        <h2
                                            class="accordion-header"
                                            id="dataDokumenHeading"
                                        >
                                            <button
                                                class="accordion-button collapsed rounded-3"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#dataDokumenCollapse"
                                                aria-expanded="false"
                                                aria-controls="dataDokumenCollapse"
                                            >
                                                <i class="bi bi-file-earmark-text me-2"></i> <strong>Data Dokumen</strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="dataDokumenCollapse"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="dataDokumenHeading"
                                        >
                                            <div class="accordion-body">
                                                <div class="row g-3">
                                                    <!-- Nomor KIP -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nomorkip"
                                                            class="form-label"
                                                        >Nomor KIP</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nomorkip"
                                                            placeholder="Masukkan nomor KIP"
                                                            name="nomorkip"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        >
                                                    </div>

                                                    <!-- Nomor KKS -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nomorkks"
                                                            class="form-label"
                                                        >Nomor KKS</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nomorkks"
                                                            placeholder="Masukkan nomor KKS"
                                                            name="nomorkks"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        >
                                                    </div>

                                                    <!-- Nomor KPS -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nomorkps"
                                                            class="form-label"
                                                        >Nomor KPS</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nomorkps"
                                                            placeholder="Masukkan nomor KPS"
                                                            name="nomorkps"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        >
                                                    </div>

                                                    <!-- Akta Lahir -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="akta_lahir"
                                                            class="form-label"
                                                        >Nomor Akta Lahir</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="akta_lahir"
                                                            placeholder="Masukkan nomor akta lahir"
                                                            name="akta_lahir"
                                                        >
                                                    </div>

                                                    <!-- NIK -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nik"
                                                            class="form-label"
                                                        >NIK</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nik"
                                                            placeholder="Masukkan NIK"
                                                            name="nik"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        >
                                                    </div>

                                                    <!-- Kartu Keluarga -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="kartu_keluarga"
                                                            class="form-label"
                                                        >Nomor Kartu Keluarga</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="kartu_keluarga"
                                                            placeholder="Masukkan nomor kartu keluarga"
                                                            name="kartu_keluarga"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                        >
                                                    </div>

                                                    <!-- NPSN -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="npsn"
                                                            class="form-label"
                                                        >NPSN</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="npsn"
                                                            placeholder="Masukkan NPSN"
                                                            name="npsn"
                                                        >
                                                    </div>

                                                    <!-- Ijazah -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="ijazah"
                                                            class="form-label"
                                                        >Nomor Ijazah</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="ijazah"
                                                            placeholder="Masukkan nomor ijazah"
                                                            name="ijazah"
                                                        >
                                                    </div>

                                                    <!-- SKHUN -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="skhun"
                                                            class="form-label"
                                                        >Nomor SKHUN</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="skhun"
                                                            placeholder="Masukkan nomor SKHUN"
                                                            name="skhun"
                                                        >
                                                    </div>

                                                    <!-- Nomor Ujian Nasional -->
                                                    <div class="col-md-6">
                                                        <label
                                                            for="nomor_ujian_nasional"
                                                            class="form-label"
                                                        >Nomor Ujian Nasional</label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="nomor_ujian_nasional"
                                                            placeholder="Masukkan nomor ujian nasional"
                                                            name="nomor_ujian_nasional"
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Data Dokumen Accordion -->
                                    <div class="accordion-item border-0 mb-3 shadow-sm">
                                        <h2
                                            class="accordion-header"
                                            id="dataAyahHeading"
                                        >
                                            <button
                                                class="accordion-button collapsed rounded-3"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#dataAyahCollapse"
                                                aria-expanded="false"
                                                aria-controls="dataAyahCollapse"
                                            >
                                                <i class="bi bi-people-fill me-2"></i> <strong>Data Ayah</strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="dataAyahCollapse"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="dataAyahHeading"
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
                                                                ></textarea>
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


                                    <!-- Data Dokumen Accordion -->
                                    <div class="accordion-item border-0 mb-3 shadow-sm">
                                        <h2
                                            class="accordion-header"
                                            id="dataIbuHeading"
                                        >
                                            <button
                                                class="accordion-button collapsed rounded-3"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#dataIbuCollapse"
                                                aria-expanded="false"
                                                aria-controls="dataIbuCollapse"
                                            >
                                                <i class="bi bi-people-fill me-2"></i><strong>Data Ibu</strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="dataIbuCollapse"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="dataIbuHeading"
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
                                                                ></textarea>
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
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="penghasilan_ibu"
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
                                                                    type="text"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                                    min="0"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Nomor HP Siswa"
                                                                    name="nomor_ibu"
                                                                />
                                                                <div class="invalid-feedback">Nomor HP ibu</div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <!-- Data Dokumen Accordion -->
                                    <div class="accordion-item border-0 mb-3 shadow-sm">
                                        <h2
                                            class="accordion-header"
                                            id="dataWaliHeading"
                                        >
                                            <button
                                                class="accordion-button collapsed rounded-3"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#dataWaliCollapse"
                                                aria-expanded="false"
                                                aria-controls="dataWaliCollapse"
                                            >
                                                <i class="bi bi-people me-2"></i><strong>Data Wali</strong>
                                            </button>
                                        </h2>
                                        <div
                                            id="dataWaliCollapse"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="dataWaliHeading""
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
                                <!-- Accordion End -->

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button
                                        class="btn btn-primary px-4 py-2"
                                        type="submit"
                                    >
                                        <i class="bi bi-save me-2"></i> Simpan Data
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Custom CSS for calm modern look */
        :root {
            --primary-color: #4f6df5;
            --primary-hover: #3d5ce4;
            --light-bg: #f8fafc;
            --border-radius: 0.5rem;
        }

        body {
            background-color: var(--light-bg);
            color: #4b5563;
        }

        .card {
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            border-color: #e2e8f0;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.15rem rgba(79, 109, 245, 0.15);
        }

        .form-label {
            color: #4b5563;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .accordion-button {
            background-color: #f1f5fd;
            color: #374151;
            padding: 1rem 1.25rem;
            font-weight: 500;
        }

        .accordion-button:not(.collapsed) {
            background-color: #e5edfe;
            color: var(--primary-color);
            box-shadow: none;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(79, 109, 245, 0.1);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .shadow-sm {
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.06) !important;
        }
    </style>

    <script>
        // Form validation
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach((form) => {
                form.addEventListener('submit', (event) => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
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

        (() => {
            const searchInput = document.getElementById('gformSearch');
            if (!searchInput) return;

            const resultsBox = document.getElementById('gformResults');
            const escapeHtml = s => String(s).replace(/[&<>"']/g, c => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;'
            }[c]));

            let timer = null;
            let lastResults = [];

            searchInput.addEventListener('input', () => {
                clearTimeout(timer);
                const q = searchInput.value.trim();
                if (q.length < 2) {
                    resultsBox.style.display = 'none';
                    resultsBox.innerHTML = '';
                    return;
                }
                timer = setTimeout(() => doSearch(q), 300);
            });

            document.addEventListener('click', (e) => {
                if (!resultsBox.contains(e.target) && e.target !== searchInput) {
                    resultsBox.style.display = 'none';
                }
            });

            async function doSearch(q) {
                resultsBox.innerHTML = '<div class="list-group-item text-muted small">Mencari...</div>';
                resultsBox.style.display = 'block';
                try {
                    const res = await fetch(`{{ route('siswa.gform-search') }}?q=${encodeURIComponent(q)}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (!data.configured) {
                        resultsBox.innerHTML = '<div class="list-group-item text-danger small">Google Sheets pendaftaran belum dikonfigurasi.</div>';
                        return;
                    }
                    lastResults = data.results || [];
                    if (!lastResults.length) {
                        resultsBox.innerHTML = '<div class="list-group-item text-muted small">Tidak ada hasil.</div>';
                        return;
                    }
                    resultsBox.innerHTML = lastResults.map((r, i) =>
                        `<button type="button" class="list-group-item list-group-item-action" data-idx="${i}">
                            <i class="bi bi-person me-2"></i>${escapeHtml(r.nama)}
                        </button>`
                    ).join('');
                    resultsBox.querySelectorAll('button[data-idx]').forEach(btn => {
                        btn.addEventListener('click', () => {
                            const idx = parseInt(btn.dataset.idx, 10);
                            applyAutofill(lastResults[idx].data || {});
                            resultsBox.style.display = 'none';
                            searchInput.value = lastResults[idx].nama;
                        });
                    });
                } catch (e) {
                    resultsBox.innerHTML = `<div class="list-group-item text-danger small">Error: ${escapeHtml(e.message)}</div>`;
                }
            }

            function applyAutofill(data) {
                const form = document.querySelector('form.needs-validation');
                if (!form) return;
                let filledCount = 0;

                for (const [field, rawVal] of Object.entries(data)) {
                    if (rawVal == null || rawVal === '') continue;
                    const value = String(rawVal).trim();
                    if (value === '') continue;

                    const el = form.querySelector(`[name="${field}"]`);
                    if (!el) continue;

                    if (el.tagName === 'SELECT') {
                        const match = Array.from(el.options).find(o => o.value === value);
                        if (match) {
                            el.value = value;
                        } else if (field === 'sekolah_asal') {
                            el.value = '__OTHER__';
                            const manual = document.getElementById('sekolah_asal_other');
                            if (manual) {
                                manual.value = value;
                                manual.classList.remove('d-none');
                                manual.required = true;
                            }
                        } else {
                            continue;
                        }
                        el.dispatchEvent(new Event('change'));
                    } else if (el.type === 'date') {
                        // Try common date formats: YYYY-MM-DD, DD/MM/YYYY
                        let iso = value;
                        const dmy = value.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/);
                        if (dmy) iso = `${dmy[3]}-${String(dmy[2]).padStart(2,'0')}-${String(dmy[1]).padStart(2,'0')}`;
                        el.value = iso;
                    } else {
                        el.value = value;
                    }
                    filledCount++;
                }

                if (filledCount > 0) {
                    alert(`Autofill berhasil — ${filledCount} field terisi dari Google Form. Periksa & lengkapi sebelum simpan.`);
                }
            }
        })();
    </script>
@endsection
