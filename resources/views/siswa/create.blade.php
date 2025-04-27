@extends('partials.master')

@section('isisiswa')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h1>Tambah Data Siswa</h1>
                <div class="card card-info card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">Formm Tambah Siswa</div>
                    </div>
                    <form
                        method="POST"
                        action="{{ route('siswa.store') }}"
                    >
                        @csrf
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
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="Nama Siswa"
                                                                name="namasiswa"
                                                                required
                                                            />
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom03"
                                                                class="form-label"
                                                            >Jurusan</label>
                                                            <select
                                                                name="jurusan"
                                                                class="form-select"
                                                                required
                                                            >
                                                                <option value="">Pilih Jurusan</option>
                                                                <option value="Teknik Sepeda Motor">Teknik Sepeda Motor
                                                                </option>
                                                                <option value="Teknik Komputer Jaringan">Teknik Komputer
                                                                    Jaringan
                                                                </option>
                                                            </select>
                                                            <div class="invalid-feedback">Pilih Jurusan</div>
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="sekolah_asal"
                                                            >Sekolah Asal</label>
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                id="validationCustom01"
                                                                placeholder="Sekolah Asal"
                                                                name="sekolah_asal"
                                                                required
                                                            />
                                                        </div>

                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom03"
                                                                class="form-label"
                                                            >Gender</label>
                                                            <select
                                                                name="jeniskelamin"
                                                                class="form-select"
                                                                required
                                                            >
                                                                <option value="">Jenis Kelamin</option>
                                                                <option value="Laki-laki">Laki-laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                            <div class="invalid-feedback">Masukan Gender</div>
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
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tempat Lahir"
                                                                    name="tempatlahir"
                                                                    required
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
                                                                    type="date"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tanggal Lahir"
                                                                    name="tanggallahir"
                                                                    required
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
                                                                ></textarea>
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
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Berat Badan"
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
                                                                    type="text"
                                                                    class="form-control"
                                                                    id="validationCustom01"
                                                                    placeholder="Tinggi Badan"
                                                                    name="tinggibadan"
                                                                />
                                                                <div class="invalid-feedback">Tinggi Badan</div>
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
                                                            >
                                                                <option selected>-</option>
                                                                <option value="Ya">Ya</option>
                                                                <option value="Tidak">Tidak</option>
                                                            </select>
                                                            <div class="invalid-feedback">Masukan kebutuhan_khusus</div>
                                                        </div>


                                                        {{-- batas --}}

                                                        <div class="col-md-6">
                                                            <label
                                                                for="validationCustom01"
                                                                class="form-label"
                                                                name="jenis_tinggal"
                                                            >Jenis tinggal</label>
                                                            <input
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
                                                                type="text"
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
                                                                    type="text"
                                                                    min="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
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
                    </script>
                </div>
            </div>
        </div>
    </main>
@endsection
