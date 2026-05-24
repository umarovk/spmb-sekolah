<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'nomor_wali', 'penghasilan_wali', 'asrama_tahfidz', 'status_seleksi', 'selektor_inisial', 'selektor_user_id', 'tanggalseleksi', 'jalurdaftar'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }

    public function pengambilanBahans()
    {
        return $this->hasMany(PengambilanBahan::class, 'siswa_id');
    }

    public function selektor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'selektor_user_id');
    }

    public function getStatusSeleksiAttribute($value)
    {
        return $value ?? 'pending';
    }

    /**
     * Apakah status seleksi siswa ini boleh diubah oleh $user?
     * - Admin: selalu boleh
     * - Belum dikunci (selektor_user_id null / status pending): siapa saja yang punya akses route boleh
     * - Sudah dikunci: hanya user yang sama yang boleh ubah ulang
     */
    public function canBeEditedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }
        if ($user->isAdmin()) {
            return true;
        }
        if (is_null($this->selektor_user_id)) {
            return true;
        }
        return (int) $this->selektor_user_id === (int) $user->id;
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