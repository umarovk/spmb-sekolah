<?php

namespace App\Exports;

use App\Models\Pembayaran;
use App\Models\Siswa;

class PaymentExport2
{
    public function export()
    {
        // Get students with their total payments
        $students = Siswa::with('pembayarans')->get();
        
        // Create headers
        $data = [
            [
                'No',
                'Nama Siswa',
                'Jurusan',
                'Jenis Kelamin',
                'Jalur Pendaftaran',
                'Keterangan',
                'Jumlah Pembayaran'
            ]
        ];

        // Add data rows
        $no = 1;
        foreach ($students as $student) {
            $totalPayment = $student->pembayarans->sum('nominal');
            
            $data[] = [
                $no++,
                $student->namasiswa,
                $student->jurusan,
                $student->jeniskelamin,
                $student->jalurdaftar,
                $student->pembayarans->count() > 0 ? 'Sudah membayar' : 'Belum membayar',
                'Rp ' . number_format($totalPayment, 0, ',', '.')
            ];
        }

        return $data;
    }

}

