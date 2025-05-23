<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengambilanBahan extends Model
{
    use HasFactory;

    protected $table = 'pengambilan_bahans';

    protected $fillable = [
        'siswa_id',
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
