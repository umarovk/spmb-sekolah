<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'namasiswa', 'jurusan', 'jeniskelamin', 'agama', 'tempatlahir', 'tanggallahir', 'tahunmasuk',
        'nik', 'nisn', 'nis', 'nomorsiswa', 'nomorkip', 'nomorkps', 'nomorkks',
        'kebutuhan_khusus', 'akta_lahir', 'kartu_keluarga', 'email', 'alamat',
        'nomorsiswa_kontak', 'sekolah_asal', 'npsn', 'ijazah', 'skhun',
        'nomor_ujian_nasional', 'tinggibadan', 'beratbadan', 'transport',
        'jenis_tinggal', 'jumlah_saudara', 'nama_ayah', 'pendidikan_ayah',
        'tempat_lahir_ayah', 'tanggal_lahir_ayah', 'alamat_ayah', 'pekerjaan_ayah',
        'penghasilan_ayah', 'nomor_ayah', 'nama_ibu', 'pendidikan_ibu',
        'tempat_lahir_ibu', 'tanggal_lahir_ibu', 'alamat_ibu', 'pekerjaan_ibu',
        'penghasilan_ibu', 'nomor_ibu', 'nama_wali', 'alamat_wali',
        'nomor_wali', 'penghasilan_wali', 'asrama_tahfidz'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($siswa) {
            if ($siswa->pembayarans()->exists()) {
                throw new \Exception('Tidak dapat menghapus data siswa yang memiliki riwayat pembayaran.');
            }
        });
    }
}