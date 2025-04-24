<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiswasTable extends Migration
{
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();

            // Informasi Pribadi Siswa
            $table->string('namasiswa');
            $table->string('jurusan');
            $table->string('jeniskelamin')->nullable();
            $table->string('agama')->nullable();
            $table->string('tempatlahir')->nullable();
            $table->date('tanggallahir')->nullable();
            $table->year('tahunmasuk')->nullable();
            $table->string('nik')->nullable();
            $table->string('nisn')->nullable();
            $table->string('nis')->nullable();
            $table->string('nomorsiswa')->nullable();
            $table->string('nomorkip')->nullable();
            $table->string('nomorkps')->nullable();
            $table->string('nomorkks')->nullable();
            $table->string('kebutuhan_khusus')->nullable();
            $table->string('akta_lahir')->nullable();
            $table->string('kartu_keluarga')->nullable();

            // Informasi Kontak Siswa
            $table->string('email')->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomorsiswa_kontak')->nullable();

            // Informasi Akademik
            $table->string('sekolah_asal')->nullable();
            $table->string('npsn')->nullable();
            $table->string('ijazah')->nullable();
            $table->string('skhun')->nullable();
            $table->string('nomor_ujian_nasional')->nullable();

            // Informasi Fisik Siswa
            $table->integer('tinggibadan')->nullable();
            $table->integer('beratbadan')->nullable();
            $table->string('transport')->nullable();
            $table->string('jenis_tinggal')->nullable();
            $table->integer('jumlah_saudara')->nullable();

            // Informasi Ayah
            $table->string('nama_ayah')->nullable();
            $table->string('pendidikan_ayah')->nullable();
            $table->string('tempat_lahir_ayah')->nullable();
            $table->date('tanggal_lahir_ayah')->nullable();
            $table->text('alamat_ayah')->nullable();
            $table->string('pekerjaan_ayah')->nullable();
            $table->string('penghasilan_ayah')->nullable();
            $table->string('nomor_ayah')->nullable();

            // Informasi Ibu
            $table->string('nama_ibu')->nullable();
            $table->string('pendidikan_ibu')->nullable();
            $table->string('tempat_lahir_ibu')->nullable();
            $table->date('tanggal_lahir_ibu')->nullable();
            $table->text('alamat_ibu')->nullable();
            $table->string('pekerjaan_ibu')->nullable();
            $table->string('penghasilan_ibu')->nullable();
            $table->string('nomor_ibu')->nullable();

            // Informasi Wali
            $table->string('nama_wali')->nullable();
            $table->text('alamat_wali')->nullable();
            $table->string('nomor_wali')->nullable();
            $table->string('penghasilan_wali')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('siswas');
    }
};
