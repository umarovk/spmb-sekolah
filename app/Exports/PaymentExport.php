<?php

namespace App\Exports;

use App\Models\Pembayaran;

class PaymentExport
{
    public function export()
    {
        $payments = Pembayaran::with('siswa')->get();
        
        // Create headers
        $data = [
            [
                'No',
                'Kode Bayar',
                'Nama Siswa',
                'Jurusan',
                'Nama Pembayaran',
                'Nominal',
                'Tanggal Bayar',
                'Keterangan',
                'Petugas',
                'Tanggal Input'
            ]
        ];

        // Add data rows
        $no = 1;
        foreach ($payments as $payment) {
            $data[] = [
                $no++,
                $payment->kode_bayar,
                $payment->siswa->namasiswa,
                $payment->siswa->jurusan,
                $payment->nama_pembayaran,
                number_format($payment->nominal, 0, ',', '.'),
                $payment->tanggal_bayar->format('d/m/Y'),
                $payment->keterangan,
                $payment->teller,
                $payment->created_at->format('d/m/Y')
            ];
        }

        return $data;
    }
}