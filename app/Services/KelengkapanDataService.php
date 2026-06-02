<?php

namespace App\Services;

use App\Models\AppSetting;
use App\Models\Siswa;

class KelengkapanDataService
{
    public const SETTING_KEY = 'required_siswa_fields';

    /** Default field wajib (dipakai kalau admin belum menentukan). */
    public const DEFAULT_REQUIRED = [
        'namasiswa', 'jurusan', 'jeniskelamin', 'agama',
        'tempatlahir', 'tanggallahir', 'alamat',
        'nik', 'nisn', 'sekolah_asal',
        'nama_ayah', 'nama_ibu',
        'jalurdaftar',
    ];

    /** Label manusiawi tiap field (untuk tampilan). */
    public const FIELD_LABELS = [
        'namasiswa'            => 'Nama Siswa',
        'jurusan'              => 'Jurusan',
        'jeniskelamin'         => 'Jenis Kelamin',
        'agama'                => 'Agama',
        'tempatlahir'          => 'Tempat Lahir',
        'tanggallahir'         => 'Tanggal Lahir',
        'tahun_lulus_smp'      => 'Tahun Lulus SMP/MTs',
        'nik'                  => 'NIK',
        'nisn'                 => 'NISN',
        'nis'                  => 'NIS',
        'nomorsiswa'           => 'No. HP Siswa',
        'nomorkip'             => 'No. KIP',
        'nomorkps'             => 'No. KPS',
        'nomorkks'             => 'No. KKS',
        'kebutuhan_khusus'     => 'Kebutuhan Khusus',
        'akta_lahir'           => 'No. Akta Lahir',
        'kartu_keluarga'       => 'No. Kartu Keluarga',
        'email'                => 'Email',
        'alamat'               => 'Alamat',
        'sekolah_asal'         => 'Sekolah Asal',
        'npsn'                 => 'NPSN',
        'ijazah'               => 'No. Ijazah',
        'skhun'                => 'No. SKHUN',
        'nomor_ujian_nasional' => 'No. Ujian Nasional',
        'tinggibadan'          => 'Tinggi Badan',
        'beratbadan'           => 'Berat Badan',
        'lingkar_kepala'       => 'Lingkar Kepala',
        'transport'            => 'Transportasi',
        'jenis_tinggal'        => 'Jenis Tinggal',
        'jumlah_saudara'       => 'Jumlah Saudara',
        'anak_ke'              => 'Anak Ke- (Urutan KK)',
        'cita_cita'            => 'Cita-cita',
        'hobi'                 => 'Hobi',
        'nama_ayah'            => 'Nama Ayah',
        'pendidikan_ayah'      => 'Pendidikan Ayah',
        'tempat_lahir_ayah'    => 'Tempat Lahir Ayah',
        'tanggal_lahir_ayah'   => 'Tanggal Lahir Ayah',
        'alamat_ayah'          => 'Alamat Ayah',
        'pekerjaan_ayah'       => 'Pekerjaan Ayah',
        'penghasilan_ayah'     => 'Penghasilan Ayah',
        'nomor_ayah'           => 'No. HP Ayah',
        'nama_ibu'             => 'Nama Ibu',
        'pendidikan_ibu'       => 'Pendidikan Ibu',
        'tempat_lahir_ibu'     => 'Tempat Lahir Ibu',
        'tanggal_lahir_ibu'    => 'Tanggal Lahir Ibu',
        'alamat_ibu'           => 'Alamat Ibu',
        'pekerjaan_ibu'        => 'Pekerjaan Ibu',
        'penghasilan_ibu'      => 'Penghasilan Ibu',
        'nomor_ibu'            => 'No. HP Ibu',
        'nama_wali'            => 'Nama Wali',
        'alamat_wali'          => 'Alamat Wali',
        'nomor_wali'           => 'No. HP Wali',
        'penghasilan_wali'     => 'Penghasilan Wali',
        'asrama_tahfidz'       => 'Asrama Tahfidz',
        'jalurdaftar'          => 'Jalur Pendaftaran',
    ];

    /** Kelompokkan field untuk UI settings agar rapi. */
    public const FIELD_GROUPS = [
        'Data Pribadi'      => ['namasiswa','jurusan','jeniskelamin','agama','tempatlahir','tanggallahir','tahun_lulus_smp','jalurdaftar','asrama_tahfidz'],
        'Identitas & Dokumen' => ['nik','nisn','nis','nomorsiswa','email','akta_lahir','kartu_keluarga','nomorkip','nomorkps','nomorkks','npsn','ijazah','skhun','nomor_ujian_nasional','kebutuhan_khusus'],
        'Domisili & Fisik'  => ['alamat','sekolah_asal','transport','jenis_tinggal','jumlah_saudara','anak_ke','tinggibadan','beratbadan','lingkar_kepala'],
        'Minat & Hobi'      => ['cita_cita','hobi'],
        'Orang Tua — Ayah'  => ['nama_ayah','pendidikan_ayah','tempat_lahir_ayah','tanggal_lahir_ayah','alamat_ayah','pekerjaan_ayah','penghasilan_ayah','nomor_ayah'],
        'Orang Tua — Ibu'   => ['nama_ibu','pendidikan_ibu','tempat_lahir_ibu','tanggal_lahir_ibu','alamat_ibu','pekerjaan_ibu','penghasilan_ibu','nomor_ibu'],
        'Wali'              => ['nama_wali','alamat_wali','nomor_wali','penghasilan_wali'],
    ];

    /** Ambil daftar field wajib dari settings (fallback default). */
    public function requiredFields(): array
    {
        $raw = AppSetting::get(self::SETTING_KEY);
        if (! $raw) {
            return self::DEFAULT_REQUIRED;
        }
        $decoded = json_decode((string) $raw, true);
        if (! is_array($decoded) || empty($decoded)) {
            return self::DEFAULT_REQUIRED;
        }
        // Sanitasi: hanya keep yang ada di FIELD_LABELS
        return array_values(array_intersect($decoded, array_keys(self::FIELD_LABELS)));
    }

    /** Apakah sebuah nilai dianggap "terisi"? */
    private function isFilled($value): bool
    {
        if (is_null($value)) return false;
        if (is_string($value)) return trim($value) !== '';
        return true;
    }

    /**
     * Hitung kelengkapan untuk satu siswa.
     * @return array{total:int, filled:int, missing:array<int,string>, percentage:int}
     */
    public function score(Siswa $siswa, ?array $required = null): array
    {
        $required = $required ?? $this->requiredFields();
        $total    = count($required);
        if ($total === 0) {
            return ['total' => 0, 'filled' => 0, 'missing' => [], 'percentage' => 100];
        }

        $missing = [];
        foreach ($required as $field) {
            if (! $this->isFilled($siswa->{$field} ?? null)) {
                $missing[] = $field;
            }
        }
        $filled = $total - count($missing);
        return [
            'total'      => $total,
            'filled'     => $filled,
            'missing'    => $missing,
            'percentage' => (int) round(($filled / $total) * 100),
        ];
    }

    /** Label manusiawi untuk sebuah field key. */
    public static function label(string $field): string
    {
        return self::FIELD_LABELS[$field] ?? $field;
    }
}
