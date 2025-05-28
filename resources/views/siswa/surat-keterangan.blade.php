<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Surat Keterangan Pendaftaran</title>
    <style>
        @page {
            size: 148mm 210mm;
            /* A4 landscape divided by 2 */
            margin: 0;
        }

        body {
            /* font-family: Arial, sans-serif; */
            font-family: "Times New Roman", Times, serif;
            line-height: 1.3;
            width: 210mm;
            height: 148mm;
            margin: 0;
            padding: 15mm;
            font-size: 11pt;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 2px;
        }

        .logo-container {
            /* flex: 0 0 20%; */
            text-align: right;
        }

        .logo {
            width: 80px;
            height: auto;
            display: block;
            align-items: right;
        }

        .school-info {
            flex: 0 0 75%;
            text-align: left;
        }

        .school-info h1 {
            font-size: 16pt;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .school-info p {
            font-size: 9pt;
            margin: 0;
            line-height: 1.2;
        }

        .divider {
            border: 0;
            border-top: 2px solid black;
            margin: 5px 0;
        }

        .title {
            font-size: 12pt;
            font-weight: bold;
            text-align: center;
            margin: 5px 0;
            /* text-decoration: underline; */
        }

        .content {
            flex: 1;
            text-align: justify;
            font-size: 11pt;
        }

        table.info {
            width: 100%;
            margin-top: -10px;
            /* margin: 1px 0; */
        }

        table.info td {
            padding: 3px 0;
            vertical-align: top;
        }

        table.info td:first-child {
            width: 35%;
        }

        .footer {
            text-align: right;
            margin-top: auto;
            padding-right: 20px;
        }

        .footer p {
            margin: 2px 0;
        }

        .text-indent {

            text-indent: 40px;
        }

        @media print {
            @page {
                size: 210mm 148mm landscape;
            }

            body {
                width: 210mm;
                height: 148mm;
                margin-top: -5mm;
                padding: 1cm;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <img
                src="{{ asset('img/logo smk cokro.png') }}"
                alt="Logo"
                class="logo"
            >
        </div>
        <div class="school-info">
            <h1>SMK COKROAMINOTO WANADADI</h1>
            <p>Jl. Hos. Cokroaminoto No. 02 Wanadadi Banjarnegara</p>
            <p>Jawa Tengah 53461 Telp. 0812 2645 3837</p>
        </div>
    </div>

    <hr style="border-top: 2px solid black; margin: 0;">
    <hr style="border-top: 1px solid black; margin: 2px 0;">

    <div class="title">
        BUKTI PENDAFTARAN
    </div>

    <div class="content">
        <!-- ...existing content... -->
        <p>Yang bertanda tangan di bawah ini, menerangkan bahwa:</p>
        <table class="info">
            <tr>
                <td>Nama</td>
                <td>: {{ $siswa->namasiswa }}</td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>: {{ $siswa->jurusan }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>: {{ $siswa->tempatlahir }},
                    {{ $siswa->tanggallahir ? \Carbon\Carbon::parse($siswa->tanggallahir)->translatedFormat('d F Y') : '-' }}
                </td>
            </tr>
            <tr>
                <td>Asal Sekolah</td>
                <td>: {{ $siswa->sekolah_asal ?? '-' }}</td>
            </tr>
        </table>

        <p class="text-indent">Telah mendaftar sebagai <strong>calon peserta didik baru di SMK Cokroaminoto Wanadadi
                Tahun
                Ajaran
                {{ now()->year }}/{{ now()->addYear()->year }}.</strong> Diharapkan kepada calon siswa untuk melakukan
            pembayaran daftar ulang maksimal 2
            minggu setelah melaksanakan rangkaian tes dan dinyatakan
            diterima.</p>

        <div class="footer">
            <p>Wanadadi, {{ $siswa->created_at->translatedFormat('d F Y') }}</p>
            <p>Panitia SPMB
                <br>
                SMK Cokroaminoto Wanadadi
            </p>
            <br><br><br>
            <p><u></u></p>
            <p>( {{ auth()->user()->nama }} )</p>
        </div>
    </div>

    <div class="no-print">
        <button
            onclick="window.print()"
            style="position: fixed; bottom: 20px; right: 20px; padding: 10px 20px;"
        >
            Cetak Surat
        </button>
    </div>
</body>

</html>
