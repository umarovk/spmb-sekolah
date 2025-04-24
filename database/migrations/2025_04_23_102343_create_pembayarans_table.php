<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembayaransTable extends Migration
{
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel siswa
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswas')->onDelete('cascade');

            // Kolom-kolom pembayaran
            $table->string('kode_bayar')->unique();
            $table->string('nama_pembayaran');
            $table->integer('nominal');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_bayar');
            $table->string('teller')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayarans');
    }
};
