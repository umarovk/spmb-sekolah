<?php

namespace App\Exports;

use App\Models\Siswa;

class SiswaExport
{
    private const ALL_FIELDS = [
        'no' => ['label' => 'No', 'value' => 'no'],
        'namasiswa' => ['label' => 'Nama Siswa', 'value' => 'namasiswa'],
        'jurusan' => ['label' => 'Jurusan', 'value' => 'jurusan'],
        'jalurdaftar' => ['label' => 'Jalur Pendaftaran', 'value' => 'jalurdaftar'],
        'jeniskelamin' => ['label' => 'Jenis Kelamin', 'value' => 'jeniskelamin'],
        'agama' => ['label' => 'Agama', 'value' => 'agama'],
        'tempatlahir' => ['label' => 'Tempat Lahir', 'value' => 'tempatlahir'],
        'tanggallahir' => ['label' => 'Tanggal Lahir', 'value' => 'tanggallahir'],
        'asrama_tahfidz' => ['label' => 'Status Asrama', 'value' => 'asrama_tahfidz'],
        'status_seleksi' => ['label' => 'Status Seleksi', 'value' => 'status_seleksi'],
        'tanggalseleksi' => ['label' => 'Tanggal Seleksi', 'value' => 'tanggalseleksi'],
        'status_pembayaran' => ['label' => 'Status Pembayaran', 'value' => 'status_pembayaran'],
        'tahun_lulus_smp' => ['label' => 'Tahun Lulus SMP/MTs', 'value' => 'tahun_lulus_smp'],
        'nik' => ['label' => 'NIK', 'value' => 'nik'],
        'nisn' => ['label' => 'NISN', 'value' => 'nisn'],
        'nis' => ['label' => 'NIS', 'value' => 'nis'],
        'nomorsiswa' => ['label' => 'Nomor Siswa', 'value' => 'nomorsiswa'],
        'nomorkip' => ['label' => 'Nomor KIP', 'value' => 'nomorkip'],
        'nomorkps' => ['label' => 'Nomor KPS', 'value' => 'nomorkps'],
        'nomorkks' => ['label' => 'Nomor KKS', 'value' => 'nomorkks'],
        'kebutuhan_khusus' => ['label' => 'Kebutuhan Khusus', 'value' => 'kebutuhan_khusus'],
        'akta_lahir' => ['label' => 'Akta Lahir', 'value' => 'akta_lahir'],
        'kartu_keluarga' => ['label' => 'Kartu Keluarga', 'value' => 'kartu_keluarga'],
        'email' => ['label' => 'Email', 'value' => 'email'],
        'alamat' => ['label' => 'Alamat', 'value' => 'alamat'],
        'nomorsiswa_kontak' => ['label' => 'Nomor Telepon', 'value' => 'nomorsiswa_kontak'],
        'sekolah_asal' => ['label' => 'Sekolah Asal', 'value' => 'sekolah_asal'],
        'npsn' => ['label' => 'NPSN', 'value' => 'npsn'],
        'ijazah' => ['label' => 'Ijazah', 'value' => 'ijazah'],
        'skhun' => ['label' => 'SKHUN', 'value' => 'skhun'],
        'nomor_ujian_nasional' => ['label' => 'Nomor Ujian Nasional', 'value' => 'nomor_ujian_nasional'],
        'tinggibadan' => ['label' => 'Tinggi Badan', 'value' => 'tinggibadan'],
        'beratbadan' => ['label' => 'Berat Badan', 'value' => 'beratbadan'],
        'lingkar_kepala' => ['label' => 'Lingkar Kepala', 'value' => 'lingkar_kepala'],
        'transport' => ['label' => 'Transport', 'value' => 'transport'],
        'jenis_tinggal' => ['label' => 'Jenis Tinggal', 'value' => 'jenis_tinggal'],
        'jumlah_saudara' => ['label' => 'Jumlah Saudara', 'value' => 'jumlah_saudara'],
        'anak_ke' => ['label' => 'Anak Ke- (Urutan KK)', 'value' => 'anak_ke'],
        'cita_cita' => ['label' => 'Cita-cita', 'value' => 'cita_cita'],
        'hobi' => ['label' => 'Hobi', 'value' => 'hobi'],
        'nama_ayah' => ['label' => 'Nama Ayah', 'value' => 'nama_ayah'],
        'pendidikan_ayah' => ['label' => 'Pendidikan Ayah', 'value' => 'pendidikan_ayah'],
        'tempat_lahir_ayah' => ['label' => 'Tempat Lahir Ayah', 'value' => 'tempat_lahir_ayah'],
        'tanggal_lahir_ayah' => ['label' => 'Tanggal Lahir Ayah', 'value' => 'tanggal_lahir_ayah'],
        'alamat_ayah' => ['label' => 'Alamat Ayah', 'value' => 'alamat_ayah'],
        'pekerjaan_ayah' => ['label' => 'Pekerjaan Ayah', 'value' => 'pekerjaan_ayah'],
        'penghasilan_ayah' => ['label' => 'Penghasilan Ayah', 'value' => 'penghasilan_ayah'],
        'nomor_ayah' => ['label' => 'Nomor Ayah', 'value' => 'nomor_ayah'],
        'nama_ibu' => ['label' => 'Nama Ibu', 'value' => 'nama_ibu'],
        'pendidikan_ibu' => ['label' => 'Pendidikan Ibu', 'value' => 'pendidikan_ibu'],
        'tempat_lahir_ibu' => ['label' => 'Tempat Lahir Ibu', 'value' => 'tempat_lahir_ibu'],
        'tanggal_lahir_ibu' => ['label' => 'Tanggal Lahir Ibu', 'value' => 'tanggal_lahir_ibu'],
        'alamat_ibu' => ['label' => 'Alamat Ibu', 'value' => 'alamat_ibu'],
        'pekerjaan_ibu' => ['label' => 'Pekerjaan Ibu', 'value' => 'pekerjaan_ibu'],
        'penghasilan_ibu' => ['label' => 'Penghasilan Ibu', 'value' => 'penghasilan_ibu'],
        'nomor_ibu' => ['label' => 'Nomor Ibu', 'value' => 'nomor_ibu'],
        'nama_wali' => ['label' => 'Nama Wali', 'value' => 'nama_wali'],
        'alamat_wali' => ['label' => 'Alamat Wali', 'value' => 'alamat_wali'],
        'nomor_wali' => ['label' => 'Nomor Wali', 'value' => 'nomor_wali'],
        'penghasilan_wali' => ['label' => 'Penghasilan Wali', 'value' => 'penghasilan_wali'],
        'tanggal_pendaftaran' => ['label' => 'Tanggal Pendaftaran', 'value' => 'tanggal_pendaftaran'],
    ];

    public static function getAvailableFields()
    {
        return self::ALL_FIELDS;
    }

    public function export($selectedFields = null)
    {
        $siswa = Siswa::with('pembayarans')->get();

        if ($selectedFields === null || empty($selectedFields)) {
            $selectedFields = array_keys(self::ALL_FIELDS);
        }

        $headers = [];
        foreach ($selectedFields as $field) {
            if (isset(self::ALL_FIELDS[$field])) {
                $headers[] = self::ALL_FIELDS[$field]['label'];
            }
        }

        $data = [$headers];

        $no = 1;
        foreach ($siswa as $s) {
            $row = [];
            foreach ($selectedFields as $field) {
                switch ($field) {
                    case 'no':
                        $row[] = $no;
                        break;
                    case 'status_pembayaran':
                        $row[] = $s->pembayarans()->exists() ? 'Sudah Bayar' : 'Belum Bayar';
                        break;
                    case 'tanggalseleksi':
                        $row[] = $s->tanggalseleksi ? date('d/m/Y', strtotime($s->tanggalseleksi)) : '-';
                        break;
                    case 'tanggal_pendaftaran':
                        $row[] = $s->created_at->format('d/m/Y');
                        break;
                    default:
                        $row[] = $s->$field ?? '';
                }
            }
            $data[] = $row;
            $no++;
        }

        return $data;
    }
}