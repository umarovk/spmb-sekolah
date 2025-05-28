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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    >
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
    >
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
        crossorigin="anonymous"
    >
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"
    ></script>


    <link
        rel="stylesheet"
        href="bootstrap-5.2.0-beta1-dist/css/bootstrap.min.css"
    >
    <link
        rel="stylesheet"
        href="bootstrap-5.2.0-beta1-dist/css/bootstrap.css"
    >
    <script src="bootstrap-5.2.0-beta1-dist/js/bootstrap.bundle.js"></script>
    <link
        rel="stylesheet"
        href="css/paper.css"
    >
    <style>
        .manual-checkbox {
            display: inline-block;
            width: 15px;
            height: 15px;
            border: 1px solid #000;
            font-size: 16px;
            line-height: 15px;
            text-align: center;
        }

        @page {
            size: A4;
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .receipt-section {
            height: 33.33vh;
            /* One-third of A4 height */
            page-break-inside: avoid;
            border-bottom: 1px dashed #000;
            padding: 5px;
            /* max-height: 297mm; */
            /* A4 height */
        }

        .sheet {
            /* height: calc(297mm / 3); */
            /* A4 height divided by 3 */
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            padding: 1mm;
        }

        @media print {
            .sheet {
                margin: 0;
                overflow: hidden;
                position: relative;
                box-sizing: border-box;
                page-break-after: always;
            }
        }

        @media print {
            @page {
                margin: 0;
                size: auto;
            }

            body {
                margin: 0;
                padding: 0;
            }

            /* Hide browser's default header and footer */
            head,
            header,
            footer {
                display: none !important;
            }

            /* Remove all URL displays */
            a[href]:after {
                content: none !important;
            }

            /* Hide date/time from footer */
            footer,
            header {
                display: none;
            }
        }
    </style>
    <title>Document</title>
</head>


<body class="AX">
    <!-- First Copy -->
    <section class="sheet">
        <!-- ...existing receipt content... -->
        <div class="container">

            <div class="row mt-2">
                <div class="col-2">
                    <img
                        src="{{ asset('img/logo smk cokro.png') }}"
                        alt="logo smkc"
                        style="width: 140px; margin-left:20px;"
                    >
                </div>
                <div class="col-10">

                    <h1 class="text-center">SMK COKROAMINOTO WANADADI</h1>
                    <h5 class="text-center">Jl. Hos. Cokroaminoto No. 02 Wanadadi Banjarnegara</h5>
                    <h5 class="text-center">Jawa Tengah 53461 Telp. 0812 2645 3837</h5>
                </div>
                <hr class="text border-10 opacity-100">
            </div>

            <div
                class="row"
                style="margin-left: 0px;"
            >

                <h5 class="text-center text-success mb-3">Kwitansi Daftar Ulang (Koperasi)</h5>
                <div class="col">

                    <label for="nopen"> <b>No. Pendaftaran </b></label>
                    <label for="isinopen"><b>: {{ $payment->kode_bayar }}</b></label>
                </div>

                <div class="col">
                    {{-- <h5 class="text-right text-success"><b>Kwitansi</b></h5> --}}
                    <label for="tanggal"><b> Tanggal </b></label>
                    <label for="isitanggal"><b>:
                            {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y') }}</b></label>
                </div>

            </div>

            <div
                class="row"
                style="margin-left: 0px;"
            >

                <div class="col">
                    <label for="nama"><b> Nama </b></label>
                    <label for="isinama"><b>: {{ $payment->siswa->namasiswa }}</b></label>
                </div>

                <div class="col">
                    <label for="jurusan"><b> Jurusan </b></label>
                    <label for="isijurusan"><b>: {{ $payment->siswa->jurusan }}</b></label>
                </div>

            </div>
            <!-- <hr class="text border-10 opacity-100"> -->

            <div class="row">
                <div
                    class="col"
                    style="margin-left: 13px;"
                >

                    Telah dibayarkan sejumlah : <b>Rp{{ number_format($payment->nominal, 0, ',', '.') }},-</b>.
                    yang terbilang : <b>{{ ucwords(terbilang($payment->nominal)) }} Rupiah.</b>
                    <br>Terimakasih telah bergabung di SMK Cokroaminoto Wanadadi. Kwitansi ini sebagai bukti pembayaran
                    peserta didik baru Tahun Ajaran {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('Y') }} /
                    {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->addYear()->format('Y') }}.
                    Mohon disimpan dengan baik.
                    </p>
                    <br>
                </div>
            </div>

            <div class="row">
                <div
                    class="col-5"
                    style="margin-left: 13px"
                >
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Bahan Osis</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Bahan Pramuka</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Atribut, dasi, topi, badge</span>
                    </div>
                </div>
                <div class="col-6">
                    <p class="text-center">Petugas Teller</p>
                    <br>
                    <br>

                    {{-- // ini diambil dari tabel keterangan models --}}
                    <p class="text-center">({{ $payment->keterangan }})</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Second Copy -->
    <section class="sheet">
        <!-- ...existing receipt content... -->
        <div class="container">

            <div class="row mt-2">
                <div class="col-2">
                    <img
                        src="{{ asset('img/logo smk cokro.png') }}"
                        alt="logo smkc"
                        style="width: 140px; margin-left:20px;"
                    >
                </div>
                <div class="col-10">

                    <h1 class="text-center">SMK COKROAMINOTO WANADADI</h1>
                    <h5 class="text-center">Jl. Hos. Cokroaminoto No. 02 Wanadadi Banjarnegara</h5>
                    <h5 class="text-center">Jawa Tengah 53461 Telp. 0812 2645 3837</h5>
                </div>
                <hr class="text border-10 opacity-100">
            </div>

            <div
                class="row"
                style="margin-left: 0px;"
            >

                <h5 class="text-center text-success mb-3">Kwitansi Daftar Ulang (Siswa)</h5>
                <div class="col">

                    <label for="nopen"> <b>No. Pendaftaran </b></label>
                    <label for="isinopen"><b>: {{ $payment->kode_bayar }}</b></label>
                </div>

                <div class="col">
                    {{-- <h5 class="text-right text-success"><b>Kwitansi</b></h5> --}}
                    <label for="tanggal"><b> Tanggal </b></label>
                    <label for="isitanggal"><b>:
                            {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y') }}</b></label>
                </div>

            </div>

            <div
                class="row"
                style="margin-left: 0px;"
            >

                <div class="col">
                    <label for="nama"><b> Nama </b></label>
                    <label for="isinama"><b>: {{ $payment->siswa->namasiswa }}</b></label>
                </div>

                <div class="col">
                    <label for="jurusan"><b> Jurusan </b></label>
                    <label for="isijurusan"><b>: {{ $payment->siswa->jurusan }}</b></label>
                </div>

            </div>
            <!-- <hr class="text border-10 opacity-100"> -->

            <div class="row">
                <div
                    class="col"
                    style="margin-left: 13px;"
                >

                    Telah dibayarkan sejumlah : <b>Rp{{ number_format($payment->nominal, 0, ',', '.') }},-</b>.
                    yang terbilang : <b>{{ ucwords(terbilang($payment->nominal)) }} Rupiah.</b>
                    <br>Terimakasih telah bergabung di SMK Cokroaminoto Wanadadi. Kwitansi ini sebagai bukti pembayaran
                    peserta didik baru Tahun Ajaran {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('Y') }} /
                    {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->addYear()->format('Y') }}.
                    Mohon disimpan dengan baik.
                    </p>
                    <br>
                </div>
            </div>

            <div class="row">
                <div
                    class="col-5"
                    style="margin-left: 13px"
                >
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Bahan Osis</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Bahan Pramuka</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Atribut, dasi, topi, badge</span>
                    </div>
                </div>
                <div class="col-6">
                    <p class="text-center">Petugas Teller</p>
                    <br>
                    <br>
                    <p class="text-center">({{ $payment->keterangan }})</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Third Copy -->
    <section class="sheet">
        <!-- ...existing receipt content... -->
        <div class="container">

            <div class="row mt-2">
                <div class="col-2">
                    <img
                        src="{{ asset('img/logo smk cokro.png') }}"
                        alt="logo smkc"
                        style="width: 140px; margin-left:20px;"
                    >
                </div>
                <div class="col-10">

                    <h1 class="text-center">SMK COKROAMINOTO WANADADI</h1>
                    <h5 class="text-center">Jl. Hos. Cokroaminoto No. 02 Wanadadi Banjarnegara</h5>
                    <h5 class="text-center">Jawa Tengah 53461 Telp. 0812 2645 3837</h5>
                </div>
                <hr class="text border-10 opacity-100">
            </div>

            <div
                class="row"
                style="margin-left: 0px;"
            >

                <h5 class="text-center text-success mb-3">Kwitansi Daftar Ulang (Bendahara)</h5>
                <div class="col">

                    <label for="nopen"> <b>No. Pendaftaran </b></label>
                    <label for="isinopen"><b>: {{ $payment->kode_bayar }}</b></label>
                </div>

                <div class="col">
                    {{-- <h5 class="text-right text-success"><b>Kwitansi</b></h5> --}}
                    <label for="tanggal"><b> Tanggal </b></label>
                    <label for="isitanggal"><b>:
                            {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y') }}</b></label>
                </div>

            </div>

            <div
                class="row"
                style="margin-left: 0px;"
            >

                <div class="col">
                    <label for="nama"><b> Nama </b></label>
                    <label for="isinama"><b>: {{ $payment->siswa->namasiswa }}</b></label>
                </div>

                <div class="col">
                    <label for="jurusan"><b> Jurusan </b></label>
                    <label for="isijurusan"><b>: {{ $payment->siswa->jurusan }}</b></label>
                </div>

            </div>
            <!-- <hr class="text border-10 opacity-100"> -->

            <div class="row">
                <div
                    class="col"
                    style="margin-left: 13px;"
                >

                    Telah dibayarkan sejumlah : <b>Rp{{ number_format($payment->nominal, 0, ',', '.') }},-</b>.
                    yang terbilang : <b>{{ ucwords(terbilang($payment->nominal)) }} Rupiah.</b>
                    <br>Terimakasih telah bergabung di SMK Cokroaminoto Wanadadi. Kwitansi ini sebagai bukti pembayaran
                    peserta didik baru Tahun Ajaran {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->format('Y') }} /
                    {{ \Carbon\Carbon::parse($payment->tanggal_bayar)->addYear()->format('Y') }}.
                    Mohon disimpan dengan baik.
                    </p>
                    <br>
                </div>
            </div>

            <div class="row">
                <div
                    class="col-5"
                    style="margin-left: 13px"
                >
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Bahan Osis</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Bahan Pramuka</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="manual-checkbox me-2"></div>
                        <span>Atribut, dasi, topi, badge</span>
                    </div>
                </div>
                <div class="col-6">
                    <p class="text-center">Petugas Teller</p>
                    <br>
                    <br>
                    <p class="text-center">({{ $payment->keterangan }})</p>
                </div>
            </div>
        </div>
    </section>
</body>
