<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->enum('asrama_tahfidz', ['Bersedia', 'Tidak'])
                  ->nullable()
                  ->after('penghasilan_wali')
                  ->comment('Status keikutsertaan dalam program asrama tahfidz');
                  
            $table->enum('status_seleksi', ['pending', 'diterima', 'ditolak', 'dipertimbangkan'])
                  ->default('pending')
                  ->after('asrama_tahfidz')
                  ->comment('Status seleksi siswa');
        });
    }

    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['asrama_tahfidz', 'status_seleksi']);
        });
    }
};