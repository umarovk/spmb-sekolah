<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengambilanBahan extends Model
{
    use HasFactory;

    protected $table = 'pengambilan_bahans';

    public const JENIS_BAHAN_LIST = [
        'Bahan Osis',
        'Bahan Pramuka',
        'Atribut',
        'Dasi',
        'Topi',
        'Badge',
        'Seragam Olahraga',
        'Kerudung',
    ];

    protected $fillable = [
        'siswa_id',
        'jenis_bahan',
        'nama_bahan',
        'jumlah',
        'tanggal_pengambilan',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pengambilan' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
