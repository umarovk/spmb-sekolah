document.addEventListener('DOMContentLoaded', function() {
    // Check if charts containers exist
    if (!document.querySelector("#jurusanChart")) return;

    const options = {
        series: [chartData.jurusan.tkj, chartData.jurusan.tsm],
        chart: {
            width: '100%',
            height: 350,
            type: 'pie'
        },
        labels: ['Teknik Komputer Jaringan', 'Teknik Sepeda Motor'],
        colors: ['#435ebe', '#fb7d44'],
        legend: {
            position: 'bottom',
            fontSize: '14px'
        },
        // ...existing options...
    };

    // Initialize and render charts only once
    const chart = new ApexCharts(document.querySelector("#jurusanChart"), options);
    const genderChart = new ApexCharts(document.querySelector("#genderChart"), genderOptions);
    const paymentStatusChart = new ApexCharts(document.querySelector("#paymentStatusChart"), paymentStatusOptions);

    chart.render();
    genderChart.render();
    paymentStatusChart.render();
});