// Sidebar toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggler = document.getElementById('sidebarToggler');
    
    if (!sidebar || !sidebarToggler) return;

    // Create overlay element
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';
    document.body.appendChild(overlay);

    // Toggle sidebar function
    function toggleSidebar() {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    }

    // Event listeners
    sidebarToggler.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Jurusan Chart
    var options = {
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
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    height: 300
                },
                legend: {
                    fontSize: '12px'
                }
            }
        }],
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " Siswa"
                }
            }
        }
    };

    // Gender Chart
    var genderOptions = {
        series: [chartData.gender.laki, chartData.gender.perempuan],
        chart: {
            width: '100%',
            height: 350,
            type: 'pie',
        },
        labels: ['Laki-laki', 'Perempuan'],
        colors: ['#3b82f6', '#ec4899'],
        legend: {
            position: 'bottom',
            fontSize: '14px'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    height: 300
                },
                legend: {
                    fontSize: '12px'
                }
            }
        }],
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " Siswa"
                }
            }
        }
    };

    // Payment Status Chart
    var paymentStatusOptions = {
        series: [chartData.payment.sudah_bayar, chartData.payment.belum_bayar],
        chart: {
            width: '100%',
            height: 350,
            type: 'pie',
        },
        labels: ['Sudah Bayar', 'Belum Bayar'],
        colors: ['#10b981', '#ef4444'], // green for paid, red for unpaid
        legend: {
            position: 'bottom',
            fontSize: '14px'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    height: 300
                },
                legend: {
                    fontSize: '12px'
                }
            }
        }],
        tooltip: {
            y: {
                formatter: function(val) {
                    return val + " Siswa"
                }
            }
        }
    };

    // Initialize charts
    var chart = new ApexCharts(document.querySelector("#jurusanChart"), options);
    var genderChart = new ApexCharts(document.querySelector("#genderChart"), genderOptions);
    var paymentStatusChart = new ApexCharts(document.querySelector("#paymentStatusChart"), paymentStatusOptions);

    chart.render();
    genderChart.render();
    paymentStatusChart.render();

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
