<?php

namespace App\Exports;

use App\Models\Siswa;

class SiswaExport
{
    public function export()
    {
        $siswa = Siswa::all();
        
        // Create headers
        $data = [
            [
                'No',
                'Nama Siswa',
                'Jurusan',
                'Jalur Pendaftaran',
                'Jenis Kelamin',
                'Agama',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Status Asrama',  // Changed label
                'Status Seleksi', // Added new column
                'Tanggal Seleksi', // Added new column
                'Tahun Lulus SMP/MTs',
                'NIK',
                'NISN',
                'NIS',
                'Nomor Siswa',
                'Nomor KIP',
                'Nomor KPS',
                'Nomor KKS',
                'Kebutuhan Khusus',
                'Akta Lahir',
                'Kartu Keluarga',
                'Email',
                'Alamat',
                'Nomor Telepon',
                'Sekolah Asal',
                'NPSN',
                'Ijazah',
                'SKHUN',
                'Nomor Ujian Nasional',
                'Tinggi Badan',
                'Berat Badan',
                'Lingkar Kepala',
                'Transport',
                'Jenis Tinggal',
                'Jumlah Saudara',
                'Anak Ke- (Urutan KK)',
                'Cita-cita',
                'Hobi',
                'Nama Ayah',
                'Pendidikan Ayah',
                'Tempat Lahir Ayah',
                'Tanggal Lahir Ayah',
                'Alamat Ayah',
                'Pekerjaan Ayah',
                'Penghasilan Ayah',
                'Nomor Ayah',
                'Nama Ibu',
                'Pendidikan Ibu',
                'Tempat Lahir Ibu',
                'Tanggal Lahir Ibu',
                'Alamat Ibu',
                'Pekerjaan Ibu',
                'Penghasilan Ibu',
                'Nomor Ibu',
                'Nama Wali',
                'Alamat Wali',
                'Nomor Wali',
                'Penghasilan Wali',
                'Tanggal Pendaftaran'
            ]
        ];

        // Add data rows
        $no = 1;
        foreach ($siswa as $s) {
            $data[] = [
                $no++,
                $s->namasiswa,
                $s->jurusan,
                $s->jalurdaftar,
                $s->jeniskelamin,
                $s->agama,
                $s->tempatlahir,
                $s->tanggallahir,
                $s->asrama_tahfidz,
                $s->status_seleksi, // Added new field
                $s->tanggalseleksi ? date('d/m/Y', strtotime($s->tanggalseleksi)) : '-', // Added new field
                $s->tahun_lulus_smp,
                $s->nik,
                $s->nisn,
                $s->nis,
                $s->nomorsiswa,
                $s->nomorkip,
                $s->nomorkps,
                $s->nomorkks,
                $s->kebutuhan_khusus,
                $s->akta_lahir,
                $s->kartu_keluarga,
                $s->email,
                $s->alamat,
                $s->nomorsiswa_kontak,
                $s->sekolah_asal,
                $s->npsn,
                $s->ijazah,
                $s->skhun,
                $s->nomor_ujian_nasional,
                $s->tinggibadan,
                $s->beratbadan,
                $s->lingkar_kepala,
                $s->transport,
                $s->jenis_tinggal,
                $s->jumlah_saudara,
                $s->anak_ke,
                $s->cita_cita,
                $s->hobi,
                $s->nama_ayah,
                $s->pendidikan_ayah,
                $s->tempat_lahir_ayah,
                $s->tanggal_lahir_ayah,
                $s->alamat_ayah,
                $s->pekerjaan_ayah,
                $s->penghasilan_ayah,
                $s->nomor_ayah,
                $s->nama_ibu,
                $s->pendidikan_ibu,
                $s->tempat_lahir_ibu,
                $s->tanggal_lahir_ibu,
                $s->alamat_ibu,
                $s->pekerjaan_ibu,
                $s->penghasilan_ibu,
                $s->nomor_ibu,
                $s->nama_wali,
                $s->alamat_wali,
                $s->nomor_wali,
                $s->penghasilan_wali,
                $s->created_at->format('d/m/Y')
            ];
        }

        return $data;
    }
}