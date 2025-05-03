<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->enum('asrama_tahfidz', ['Bersedia', 'Tidak'])->nullable()->after('jeniskelamin');
        });
    }

    public function down()
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('asrama_tahfidz');
        });
    }
};