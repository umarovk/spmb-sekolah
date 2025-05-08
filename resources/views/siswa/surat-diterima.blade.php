<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Surat Keterangan diterima</title>
    <style>
        @page {
            size: 210mm 148mm;
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
            text-align: center;
            margin-top: auto;
            padding-left: 10cm;

        }

        .footer p {
            margin: 2px 0;
        }

        .text-indent {

            text-indent: 20px;
        }

        @media print {
            @page {
                size: 210mm 297mm;
                /* A4 size */
                margin: 0;
            }

            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 1cm;
                /* Seragamkan padding di semua sisi */
                -webkit-print-color-adjust: exact;
            }

            .content {
                margin: 0 1.5cm;
                /* Tambahkan margin di konten */
            }

            .footer {
                margin-right: 1.5cm;
                /* Sesuaikan margin footer */
            }
        }
    </style>
</head>

<div class="no-print">
    <button
        onclick="window.print()"
        style="position: fixed; bottom: 20px; right: 20px; padding: 10px 20px;"
    >
        Cetak Surat
    </button>
</div>


<section class="sheet padding-10mm">

    <div class="container">
        <div class="row">
            <div class="col">
                <img
                    src="{{ asset('img/cop-header.jpg') }}"
                    class="img-fluid"
                    alt="cop surat"
                    style="width: 180mm"
                >

            </div>
        </div>
        <div class="row">
            <br>
            <div class="col">
                <label for="nosurat">No &emsp;&emsp; :
                    ID{{ $siswa->id }}/SPMB-A3/SMK.C/WND/{{ now()->year }}</label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="nosurat">Lamp &emsp;: -</label>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <label for="nosurat">Hal &emsp;&emsp;: <b>Pengumuman</b></label>
            </div>
        </div>

        <div class="row">
            <P style="margin-left:2em">
                Kepada Yth.<b>
                    <br>Bpk/Ibu Wali Calon siswa Baru
                    <br>SMK Cokroaminoto Wanadadi {{ now()->year }}/{{ now()->addYear()->year }}
                    <br>di Tempat</b>
                <br>
            </p>

            <img
                src="{{ asset('img/salam-open.jpg') }}"
                alt="Assalamu'alaikum Wr. Wb."
                style="width:180px; margin-left:2em;"
            >

            {{-- <h3 style="margin-left:2em;">Assalamu'alaikum Wr. Wb.</h3> --}}
            <p style="margin-left:2em; margin-right:4em; text-align: justify;">
                Disampaikan dengan hormat, berkenaan dengan hasil penilaian oleh tim seleksi
                calon pesera didik baru SMK Cokroaminoto Wanadadi Tahun Pelajaran
                {{ now()->year }}/{{ now()->addYear()->year }},
                kami beritahukan bahwa :

            </P>
        </div>
        <div class="row">
            <div
                class="col"
                style="margin-left:2em"
            >
                <label for="nama"><b> Nama &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;:</b></label>
                <label for="isinama"><b> {{ $siswa->namasiswa }}</b></label>
            </div>
        </div>

        <div class="row">
            <div
                class="col"
                style="margin-left:2em"
            >
                <label for="jurusan"><b> Program keahlian&emsp;:</b></label>
                <label for="jurusan"><b>{{ $siswa->jurusan }}</b></label>
            </div>
        </div>

        <div class="row">
            <div
                class="col"
                style="margin-left:2em"
            >
                <label for="sekolah"><b> Sekolah Asal&emsp;&emsp;&emsp;&nbsp;:</b></label>
                <label for="sekolah"><b>{{ $siswa->sekolah_asal }}</b></label>
            </div>
        </div>

        <div class="row">
            <div
                class="col"
                style="text-align: center; width:200mm"
            >
                <p><br>Dinyatakan :</p><br>
                <p style="font-size:25px; margin-top:-30px; text-decoration-line: underline;"><b>DITERIMA / </b><b
                        style="text-decoration-line: line-through"
                    >DITOLAK</b></p>
                <p style="margin-top: -20px;">
                    Menjadi siswa SMK Cokroaminoto Wanadadi
                    <br>Tahun Pelajaran {{ now()->year }}/{{ now()->addYear()->year }}

                </p>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <p style="text-align: justify; margin-left:2em; margin-right:4em">
                    <br>Bersama ini kami ucapkan selamat dan kami berharap kesempatan ini dapat dimanfaatkan dengan
                    sebaik-baiknya sebagai jalan menuju sukses meraih cita-cita dan masa depan putra-putri
                    Bapak/Ibu.

                    <br><br>Adapun proses selanjutnya setelah diterima menjadi siswa SMK Cokroaminoto Wanadadi
                    adalah melakukan daftar ulang dengan ketentuan sebagaimana terlampir.

                    <br><br>Demikian pemberitahuan ini kami sampaikan, atas perhatiannya kami sampaikan terima
                    kasih.

                    <br><br>Billaahi fie Sabilil Haq

                </P>
            </div>
            <img
                src="{{ asset('img/salam-close.png') }}"
                alt="Assalamu'alaikum Wr. Wb."
                style="width:180px; margin-left:2em;"
            >

        </div>


    </div>
    </div>
    <div class="container">
        <div class="row">
            <div
                class="col"
                style="margin-left:100mm; text-align: center;"
            >
                <p>Wanadadi, {{ $tanggal }}</p>
                <p style="margin-top: -10px;">Kepala SMK Cokroaminoto Wanadadi</p>
                <img
                    src="{{ asset('img/ttd-kepsek.png') }}"
                    alt=""
                    style="width:150px; margin-top:-20px;"
                >
                <p style="text-decoration: underline; margin-top:-10px;"><b>Soeprijadi, S.Kom</b></p>
                <p style="margin-top: -10px;">NPPY. 20080714181</p>

            </div>
        </div>
    </div>
</section>




</body>

</html>
