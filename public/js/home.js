const chartData = {
    jurusan: {
        tkj: {{ $jurusanData['tkj'] }},
        tsm: {{ $jurusanData['tsm'] }}
    },
    gender: {
        laki: {{ $genderData['laki'] }},
        perempuan: {{ $genderData['perempuan'] }}
    },
    payment: {
        sudah_bayar: {{ $paymentStatusData['sudah_bayar'] }},
        belum_bayar: {{ $paymentStatusData['belum_bayar'] }}
    }
}; 