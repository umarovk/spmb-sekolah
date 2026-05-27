<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengambilan_bahans', function (Blueprint $table) {
            $table->string('jenis_bahan')->nullable()->after('siswa_id');
            $table->date('tanggal_pengambilan')->nullable()->change();
        });

        // Backfill: existing rows with combined string "Bahan Osis, Pramuka, ..." → expand into per-item rows
        $items = ['Bahan Osis', 'Bahan Pramuka', 'Atribut', 'Dasi', 'Topi', 'Badge', 'Seragam Olahraga'];
        $legacy = DB::table('pengambilan_bahans')->whereNull('jenis_bahan')->get();

        foreach ($legacy as $row) {
            foreach ($items as $item) {
                DB::table('pengambilan_bahans')->insert([
                    'siswa_id' => $row->siswa_id,
                    'jenis_bahan' => $item,
                    'nama_bahan' => $item,
                    'jumlah' => 1,
                    'tanggal_pengambilan' => $row->tanggal_pengambilan,
                    'status' => 'diberikan',
                    'keterangan' => $row->keterangan,
                    'created_at' => $row->created_at,
                    'updated_at' => $row->updated_at,
                ]);
            }
            DB::table('pengambilan_bahans')->where('id', $row->id)->delete();
        }
    }

    public function down(): void
    {
        Schema::table('pengambilan_bahans', function (Blueprint $table) {
            $table->dropColumn('jenis_bahan');
        });
    }
};
