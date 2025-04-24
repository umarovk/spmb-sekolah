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




                                <p></p>
                                {{-- batas --}}

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
                                        <option value="Teknik Sepeda Motor">Teknik Sepeda Motor</option>
                                        <option value="Teknik Komputer Jaringan">Teknik Komputer Jaringan</option>
                                    </select>
                                    <div class="invalid-feedback">Pilih Jurusan</div>
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
                                        />
                                        <div class="invalid-feedback">Tanggal Lahir</div>
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
                                    />
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
                                    >jenis_tinggal</label>
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
                                    >jumlah_saudara</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="validationCustom01"
                                        placeholder="jumlah_saudara"
                                        name="jumlah_saudara"
                                    />
                                </div>


                                {{-- batas --}}







                                <div class="p-3 bg-info bg-opacity-10 border border-info border-start-0 rounded-end">
                                    Data Dokumen Siswa
                                    <h3>
                                        <button
                                            type="button"
                                            id="toogle-berkas"
                                            class="btn btn btn-secondary"
                                        >Tampilkan Dokumen Siswa</button>
                                    </h3>
                                </div>

                                <div
                                    id="section-berkas"
                                    style="display: none;"
                                >

                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustomUsername"
                                                    class="form-label"
                                                    name="nomorkip"
                                                >nomor kip</label>
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
                                                    <div class="invalid-feedback">Tulis nomor kip</div>
                                                </div>
                                            </div>

                                            {{-- batas --}}

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustomUsername"
                                                    class="form-label"
                                                    name="nomorkks"
                                                >nomor kks</label>
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
                                                    <div class="invalid-feedback">Tulis nomor kks</div>
                                                </div>
                                            </div>

                                            {{-- batas --}}

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustomUsername"
                                                    class="form-label"
                                                    name="nomorkps"
                                                >nomor kps</label>
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
                                                    <div class="invalid-feedback">Tulis nomor kps</div>
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
                                                >ijazah</label>
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
                                                >skhun</label>
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
                                                >nomor_ujian_nasional</label>
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


                                <div class="p-3 bg-info bg-opacity-10 border border-info border-start-0 rounded-end">
                                    Data Ayah Siswa
                                    <h3>
                                        <button
                                            type="button"
                                            id="toogle-ayah"
                                            class="btn btn btn-secondary"
                                        >Tampilkan Form Ayah</button>
                                    </h3>
                                </div>

                                <div
                                    id="section-ayah"
                                    style="display: none;"
                                >

                                    <div class="card-body">
                                        <div class="row g-3">

                                            {{-- ayah --}}

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    name="nama_ayah"
                                                >nama_ayah</label>
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
                                                >pendidikan_ayah</label>
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
                                                >tempat_lahir_ayah</label>
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
                                                >tanggal_lahir_ayah</label>
                                                <div class="input-group has-validation">
                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        id="validationCustom01"
                                                        placeholder="tanggal_lahir_ayah"
                                                        name="tanggal_lahir_ayah"
                                                    />
                                                    <div class="invalid-feedback">tanggal_lahir_ayah</div>
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

                                <div class="p-3 bg-info bg-opacity-10 border border-info border-start-0 rounded-end">
                                    Data Ibu Siswa
                                    <h3>
                                        <button
                                            type="button"
                                            id="toogle-ibu"
                                            class="btn btn btn-secondary"
                                        >Tampilkan Form Ibu</button>
                                    </h3>
                                </div>

                                {{-- ibu --}}

                                <div
                                    id="section-ibu"
                                    style="display: none;"
                                >

                                    <div class="card-body">
                                        <div class="row g-3">

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    name="nama_ibu"
                                                >nama_ibu</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="validationCustom01"
                                                    placeholder="nama_ibu"
                                                    name="nama_ibu"
                                                />
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    name="pendidikan_ibu"
                                                >pendidikan_ibu</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="validationCustom01"
                                                    placeholder="pendidikan_ibu"
                                                    name="pendidikan_ibu"
                                                />
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    name="tempat_lahir_ibu"
                                                >tempat_lahir_ibu</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="validationCustom01"
                                                    placeholder="tempat_lahir_ibu"
                                                    name="tempat_lahir_ibu"
                                                />
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustomUsername"
                                                    class="form-label"
                                                    name="tanggal_lahir_ibu"
                                                >tanggal_lahir_ibu</label>
                                                <div class="input-group has-validation">
                                                    <input
                                                        type="date"
                                                        class="form-control"
                                                        id="validationCustom01"
                                                        placeholder="tanggal_lahir_ibu"
                                                        name="tanggal_lahir_ibu"
                                                    />
                                                    <div class="invalid-feedback">tanggal_lahir_ibu</div>
                                                </div>
                                            </div>

                                            {{-- batas --}}

                                            <div class=     "col-md-6">
                                                <label
                                                    for="validationCustomUsername"
                                                    class="form-label"
                                                    name="alamat_ibu"
                                                >alamat_ibu</label>
                                                <div class="input-group has-validation">
                                                    <textarea
                                                        type="textarea"
                                                        class="form-control"
                                                        id="validationCustom01"
                                                        placeholder="alamat_ibu"
                                                        name="alamat_ibu"
                                                    ></textarea>
                                                    <div class="invalid-feedback">Tulis alamat_ibu</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    name="pekerjaan_ibu"
                                                >pekerjaan_ibu</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    id="validationCustom01"
                                                    placeholder="pekerjaan_ibu"
                                                    name="pekerjaan_ibu"
                                                />
                                            </div>

                                            <div class="col-md-6">
                                                <label
                                                    for="validationCustom01"
                                                    class="form-label"
                                                    name="penghasilan_ibu"
                                                >penghasilan_ibu</label>
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
                                                    <div class="invalid-feedback">Nomor HP ibu zaaa</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>


                                <div class="p-3 bg-info bg-opacity-10 border border-info border-start-0 rounded-end">
                                    Data Wali Siswa
                                    <div class="col-md-6">
                                        <h3><button
                                                type="button"
                                                id="toogle-wali"
                                                class="btn btn btn-secondary"
                                            >Tampilkan Form Wali</button></h3>
                                    </div>
                                </div>

                                <div
                                    id="section-wali"
                                    style="display: none;"
                                >

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

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const toggleAlamatButton = document.getElementById('toogle-wali');
                            const sectionAlamat = document.getElementById('section-wali');
                            const togglePendidikanCheckbox = document.getElementById('toggle-pendidikan');
                            const sectionPendidikan = document.getElementById('section-pendidikan');

                            if (toggleAlamatButton && sectionAlamat) {
                                toggleAlamatButton.addEventListener('click', function() {
                                    sectionAlamat.style.display = sectionAlamat.style.display === 'none' ? 'block' : 'none';
                                });
                            }

                            if (togglePendidikanCheckbox && sectionPendidikan) {
                                togglePendidikanCheckbox.addEventListener('change', function() {
                                    sectionPendidikan.style.display = this.checked ? 'block' : 'none';
                                });
                            }
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const toggleAlamatButton = document.getElementById('toogle-ayah');
                            const sectionAlamat = document.getElementById('section-ayah');
                            const togglePendidikanCheckbox = document.getElementById('toggle-pendidikan');
                            const sectionPendidikan = document.getElementById('section-pendidikan');

                            if (toggleAlamatButton && sectionAlamat) {
                                toggleAlamatButton.addEventListener('click', function() {
                                    sectionAlamat.style.display = sectionAlamat.style.display === 'none' ? 'block' : 'none';
                                });
                            }

                            if (togglePendidikanCheckbox && sectionPendidikan) {
                                togglePendidikanCheckbox.addEventListener('change', function() {
                                    sectionPendidikan.style.display = this.checked ? 'block' : 'none';
                                });
                            }
                        });
                    </script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const toggleAlamatButton = document.getElementById('toogle-ibu');
                            const sectionAlamat = document.getElementById('section-ibu');
                            const togglePendidikanCheckbox = document.getElementById('toggle-pendidikan');
                            const sectionPendidikan = document.getElementById('section-pendidikan');

                            if (toggleAlamatButton && sectionAlamat) {
                                toggleAlamatButton.addEventListener('click', function() {
                                    sectionAlamat.style.display = sectionAlamat.style.display === 'none' ? 'block' : 'none';
                                });
                            }

                            if (togglePendidikanCheckbox && sectionPendidikan) {
                                togglePendidikanCheckbox.addEventListener('change', function() {
                                    sectionPendidikan.style.display = this.checked ? 'block' : 'none';
                                });
                            }
                        });
                    </script>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const toggleAlamatButton = document.getElementById('toogle-berkas');
                            const sectionAlamat = document.getElementById('section-berkas');
                            const togglePendidikanCheckbox = document.getElementById('toggle-pendidikan');
                            const sectionPendidikan = document.getElementById('section-pendidikan');

                            if (toggleAlamatButton && sectionAlamat) {
                                toggleAlamatButton.addEventListener('click', function() {
                                    sectionAlamat.style.display = sectionAlamat.style.display === 'none' ? 'block' : 'none';
                                });
                            }

                            if (togglePendidikanCheckbox && sectionPendidikan) {
                                togglePendidikanCheckbox.addEventListener('change', function() {
                                    sectionPendidikan.style.display = this.checked ? 'block' : 'none';
                                });
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </main>
@endsection
