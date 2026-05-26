<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('selektor_inisial', 3)
                  ->nullable()
                  ->after('status_seleksi')
                  ->comment('Inisial 3 huruf user yang terakhir mengubah status seleksi');
        });
    }

    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('selektor_inisial');
        });
    }
};
