<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->unsignedBigInteger('selektor_user_id')
                  ->nullable()
                  ->after('selektor_inisial')
                  ->comment('User id yang mengunci/mengubah status seleksi siswa');

            $table->foreign('selektor_user_id')
                  ->references('id')->on('users')
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropForeign(['selektor_user_id']);
            $table->dropColumn('selektor_user_id');
        });
    }
};
