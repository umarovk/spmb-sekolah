/**
 * Dashboard Charts
 * Modern minimalist design for SMK Cokroaminoto Wanadadi
 */

document.addEventListener('DOMContentLoaded', function() {
    // Jurusan Chart
    const jurusanOptions = {
        series: [chartData.jurusan.tkj, chartData.jurusan.tsm],
        labels: ['TKJ', 'TSM'],
        chart: {
            type: 'donut',
            height: '100%',
            fontFamily: 'Inter, sans-serif',
            toolbar: {
                show: false
            }
        },
        colors: ['#818cf8', '#93c5fd'],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
                radius: 5
            },
            itemMargin: {
                horizontal: 10,
                vertical: 0
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        name: {
                            fontSize: '14px',
                            fontWeight: 500,
                            color: '#6b7280'
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 600,
                            color: '#1f2937',
                            formatter: function (val) {
                                return val;
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 500,
                            color: '#6b7280',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            enabled: true,
            theme: 'light',
            style: {
                fontSize: '14px'
            }
        },
        stroke: {
            width: 2,
            colors: ['#fff']
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        ]
    };

    // Gender Chart
    const genderOptions = {
        series: [chartData.gender.laki, chartData.gender.perempuan],
        labels: ['Laki-laki', 'Perempuan'],
        chart: {
            type: 'donut',
            height: '100%',
            fontFamily: 'Inter, sans-serif',
            toolbar: {
                show: false
            }
        },
        colors: ['#60a5fa', '#f472b6'],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
                radius: 5
            },
            itemMargin: {
                horizontal: 10,
                vertical: 0
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        name: {
                            fontSize: '14px',
                            fontWeight: 500,
                            color: '#6b7280'
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 600,
                            color: '#1f2937',
                            formatter: function (val) {
                                return val;
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 500,
                            color: '#6b7280',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            enabled: true,
            theme: 'light',
            style: {
                fontSize: '14px'
            }
        },
        stroke: {
            width: 2,
            colors: ['#fff']
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        ]
    };

    // Payment Status Chart
    const paymentOptions = {
        series: [chartData.payment.sudah_bayar, chartData.payment.belum_bayar],
        labels: ['Sudah Bayar', 'Belum Bayar'],
        chart: {
            type: 'donut',
            height: '100%',
            fontFamily: 'Inter, sans-serif',
            toolbar: {
                show: false
            }
        },
        colors: ['#34d399', '#f87171'],
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 10,
                height: 10,
                radius: 5
            },
            itemMargin: {
                horizontal: 10,
                vertical: 0
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '60%',
                    labels: {
                        show: true,
                        name: {
                            fontSize: '14px',
                            fontWeight: 500,
                            color: '#6b7280'
                        },
                        value: {
                            fontSize: '20px',
                            fontWeight: 600,
                            color: '#1f2937',
                            formatter: function (val) {
                                return val;
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            fontWeight: 500,
                            color: '#6b7280',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            }
                        }
                    }
                }
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            enabled: true,
            theme: 'light',
            style: {
                fontSize: '14px'
            }
        },
        stroke: {
            width: 2,
            colors: ['#fff']
        },
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        height: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        ]
    };

    // Initialize charts
    const jurusanChart = new ApexCharts(document.querySelector("#jurusanChart"), jurusanOptions);
    const genderChart = new ApexCharts(document.querySelector("#genderChart"), genderOptions);
    const paymentStatusChart = new ApexCharts(document.querySelector("#paymentChart"), paymentOptions);

    // Render charts
    jurusanChart.render();
    genderChart.render();
    paymentStatusChart.render();

    // Handle responsive behavior
    window.addEventListener('resize', function() {
        jurusanChart.render();
        genderChart.render();
        paymentStatusChart.render();
    });

    // Initialize tooltips if Bootstrap 5 is used
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
});