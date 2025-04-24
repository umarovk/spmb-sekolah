<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayarans';

    protected $fillable = [
        'siswa_id',
        'kode_bayar',
        'nama_pembayaran',
        'nominal',
        'keterangan',
        'tanggal_bayar',
        'teller',
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
    ];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    // Fungsi total semua pembayaran
    public static function totalPembayaran()
    {
        return self::sum('nominal');
    }
}