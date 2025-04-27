<?php

if (!function_exists('terbilang')) {
    function terbilang($number)
    {
        $angka = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

        if ($number < 12) {
            return ' ' . $angka[$number];
        } elseif ($number < 20) {
            return terbilang($number - 10) . ' belas';
        } elseif ($number < 100) {
            return terbilang($number / 10) . ' puluh' . terbilang($number % 10);
        } elseif ($number < 200) {
            return 'seratus' . terbilang($number - 100);
        } elseif ($number < 1000) {
            return terbilang($number / 100) . ' ratus' . terbilang($number % 100);
        } elseif ($number < 2000) {
            return 'seribu' . terbilang($number - 1000);
        } elseif ($number < 1000000) {
            return terbilang($number / 1000) . ' ribu' . terbilang($number % 1000);
        } elseif ($number < 1000000000) {
            return terbilang($number / 1000000) . ' juta' . terbilang($number % 1000000);
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Kwitansi Pembayaran #{{ $payment->kode_bayar }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .kwitansi {
            border: 1px solid #000;
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
        }

        .table td {
            padding: 8px;
        }
    </style>
</head>

<body>
    <div class="kwitansi">
        <div class="header">
            <h2>KWITANSI PEMBAYARAN</h2>
            <p>SMK COKROAMINOTO WANADADI</p>
        </div>

        <div class="content">
            <table class="table">
                <tr>
                    <td width="200">No. Kwitansi</td>
                    <td>: {{ $payment->kode_bayar }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td>Telah terima dari</td>
                    <td>: {{ $payment->siswa->namasiswa }}</td>
                </tr>
                <tr>
                    <td>Untuk Pembayaran</td>
                    <td>: {{ $payment->nama_pembayaran }}</td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>: Rp{{ number_format($payment->nominal, 0, ',', '.') }},-</td>
                </tr>
                <tr>
                    <td>Terbilang</td>
                    <td>: {{ ucwords(terbilang($payment->nominal)) }} Rupiah</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>{{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y') }}</p>
            <br><br><br>
            <p>{{ $payment->teller }}</p>
        </div>
    </div>
</body>

</html>
