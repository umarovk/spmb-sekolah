<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta
        http-equiv="Content-Type"
        content="text/html; charset=utf-8"
    />
    <title>SPMB by Umarov</title>
    <!--begin::Primary Meta Tags-->
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    />


    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
        crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
        crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
        crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link
        rel="stylesheet"
        href="../LTE/dist/css/adminlte.css"
    />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0="
        crossorigin="anonymous"
    />
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css"
    >
    <!-- jsvectormap -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4="
        crossorigin="anonymous"
    />
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=delete"
    />
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,400,0,0&icon_names=account_circle"
    />




    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- This is where styles pushed from individual views will appear -->
    <link
        rel="stylesheet"
        href="{{ asset('css/sidebar.css') }}"
    >

    <link
        rel="stylesheet"
        href="{{ asset('css/dashboard.css') }}"
    >
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed" style="background-color: #f4f6f9;">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Sidebar-->
        <aside
            class="app-sidebar"
            id="sidebar"
        >
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand d-flex align-items-center justify-content-center py-3">
                <!--begin::Brand Link-->
                <a
                    href="/"
                    class="brand-link text-decoration-none d-flex align-items-center"
                >
                    <!-- You can add a logo here if needed -->
                    <span class="brand-text fw-bold fs-4 text-primary">SPMB</span>
                </a>
                <!--end::Brand Link-->
                <button class="btn btn-sm btn-link d-lg-none ms-auto text-dark sidebar-close">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <!--end::Sidebar Brand-->

            <!--begin::Sidebar School Logo-->
            <div class="user-profile text-center py-4 border-bottom mb-2">
                <div class="user-avatar mb-2">
                    <img
                        src="{{ asset(config('app.school_logo')) }}"
                        class="rounded-circle shadow"
                        alt="Logo Sekolah"
                        width="70"
                        height="70"
                        onerror="this.src='{{ asset('img/user.png') }}'"
                    />
                </div>
                <div class="user-info">
                    <h6 class="mb-0 text-dark">{{ auth()->user()->nama }}</h6>
                    <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
                </div>
            </div>
            <!--end::Sidebar School Logo-->

            <!--begin::Sidebar Wrapper-->
            @auth
                <div class="sidebar-wrapper px-2">
                    <nav class="mt-2">
                        <ul
                            class="nav sidebar-menu flex-column"
                            role="menu"
                        >
                            <!-- Dashboard -->
                            <li class="nav-item mb-1">
                                <a
                                    href="{{ route('home') }}"
                                    class="nav-link rounded-pill py-2 {{ Request::is('/') ? 'active bg-light text-primary' : 'text-dark' }}"
                                >
                                    <i class="nav-icon bi bi-speedometer2 me-2"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <!-- Student Management (Guest & Admin) -->
                            @if (auth()->user()->isAdmin() ||
                                    auth()->user()->isGuest() ||
                                    auth()->user()->isTeller() ||
                                    auth()->user()->isSelektor())
                                <li class="nav-item mb-1">
                                    <a
                                        href="{{ route('tabelsiswa') }}"
                                        class="nav-link rounded-pill py-2 {{ Request::routeIs('tabelsiswa*', 'siswa.*') ? 'active bg-light text-primary' : 'text-dark' }}"
                                    >
                                        <i class="nav-icon bi bi-people-fill me-2"></i>
                                        <span>Data Siswa</span>
                                    </a>
                                </li>
                            @endif

                            <!-- Seleksi Siswa (Selektor & Admin) -->
                            @if (auth()->user()->isSelektor() || auth()->user()->isAdmin())
                                <li class="nav-item mb-1">
                                    <a
                                        href="{{ route('seleksi.index') }}"
                                        class="nav-link rounded-pill py-2 {{ Request::routeIs('seleksi.*') ? 'active bg-light text-primary' : 'text-dark' }}"
                                    >
                                        <i class="nav-icon bi bi-clipboard-check me-2"></i>
                                        <span>Seleksi Siswa</span>
                                    </a>
                                </li>
                            @endif

                            <!-- Payment Management (Teller & Admin) -->
                            @if (auth()->user()->isAdmin() || auth()->user()->isTeller())
                                <li class="nav-item mb-1">
                                    <a
                                        href="{{ route('payments.index') }}"
                                        class="nav-link rounded-pill py-2 {{ Request::routeIs('payments.*', 'tabelbayar') ? 'active bg-light text-primary' : 'text-dark' }}"
                                    >
                                        <i class="nav-icon bi bi-cash-coin me-2"></i>
                                        <span>Pembayaran</span>
                                    </a>
                                </li>
                            @endif

                            <!-- Student Management (Guest & Admin) -->
                            @if (auth()->user()->isAdmin() || auth()->user()->isSelektor())
                                <li class="nav-item mb-1">
                                    <a
                                        href="{{ route('bahan.index') }}"
                                        class="nav-link rounded-pill py-2 {{ Request::routeIs('bahan.*', 'index') ? 'active bg-light text-primary' : 'text-dark' }}"
                                    >
                                        <i class="nav-icon bi bi-people-fill me-2"></i>
                                        <span>Pengambilan Bahan</span>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item mb-1">
                                <a
                                    href="{{ route('siswa.rangkuman') }}"
                                    class="nav-link rounded-pill py-2 {{ Request::routeIs('users.*') ? 'active bg-light text-primary' : 'text-dark' }}"
                                >
                                    <i class="nav-icon bi bi-people me-2"></i>
                                    <span>Rangkuman SPMB</span>
                                </a>
                            </li>

                            @if (auth()->user()->isAdmin())
                                <!-- User Management (Admin Only) -->
                                <li class="nav-item mb-1">
                                    <a
                                        href="{{ route('users.index') }}"
                                        class="nav-link rounded-pill py-2 {{ Request::routeIs('users.*') ? 'active bg-light text-primary' : 'text-dark' }}"
                                    >
                                        <i class="nav-icon bi bi-people me-2"></i>
                                        <span>Manajemen User</span>
                                    </a>
                                </li>


                                <!-- Backup Database (Admin Only) -->
                                <li class="nav-item mb-1">
                                    <a
                                        href="{{ route('admin.backup.index') }}"
                                        class="nav-link rounded-pill py-2 {{ Request::routeIs('admin.backup.*') ? 'active bg-light text-primary' : 'text-dark' }}"
                                    >
                                        <i class="nav-icon bi bi-database-down me-2"></i>
                                        <span>Backup Database</span>
                                    </a>
                                </li>
                            @endif



                            <!-- Logout -->
                            <li class="nav-item mt-3">
                                <form
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah yakin ingin keluar?')"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="nav-link btn btn-outline-danger w-100 rounded-pill"
                                    >
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endauth
        </aside>
        <!--end::Sidebar-->
        <main class="dashboard-main">
            @yield('content')
            @yield('isihome')
            @yield('isisiswa')
            @yield('editisisiswa')
            @yield('indexbayar')
            @yield('editsiswa')
            @yield('tabelpembayaran')
            @yield('tambahbayar')
            @yield('welcome')
            @yield('editbayar')
            {{-- <p>INI KONTENNN pada master</p> --}}

    </div>
    <!--end::App Wrapper-->

    <!--begin::Mobile Bottom Navigation-->
    @auth
    <nav class="mobile-bottom-nav d-lg-none">
        <a href="{{ route('home') }}"
           class="mobile-nav-item {{ Request::is('/') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        @if (auth()->user()->isAdmin() || auth()->user()->isGuest() || auth()->user()->isTeller() || auth()->user()->isSelektor())
        <a href="{{ route('tabelsiswa') }}"
           class="mobile-nav-item {{ Request::routeIs('tabelsiswa*', 'siswa.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span>Siswa</span>
        </a>
        @endif

        @if (auth()->user()->isSelektor() || auth()->user()->isAdmin())
        <a href="{{ route('seleksi.index') }}"
           class="mobile-nav-item {{ Request::routeIs('seleksi.*') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i>
            <span>Seleksi</span>
        </a>
        @endif

        @if (auth()->user()->isAdmin() || auth()->user()->isTeller())
        <a href="{{ route('payments.index') }}"
           class="mobile-nav-item {{ Request::routeIs('payments.*', 'tabelbayar') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i>
            <span>Bayar</span>
        </a>
        @endif

        @if (auth()->user()->isAdmin() || auth()->user()->isSelektor())
        <a href="{{ route('bahan.index') }}"
           class="mobile-nav-item {{ Request::routeIs('bahan.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i>
            <span>Bahan</span>
        </a>
        @endif

        <a href="{{ route('siswa.rangkuman') }}"
           class="mobile-nav-item {{ Request::routeIs('siswa.rangkuman') ? 'active' : '' }}">
            <i class="bi bi-bar-chart-fill"></i>
            <span>Rekap</span>
        </a>

        @if (auth()->user()->isAdmin())
        <a href="{{ route('users.index') }}"
           class="mobile-nav-item {{ Request::routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i>
            <span>Users</span>
        </a>
        <a href="{{ route('admin.backup.index') }}"
           class="mobile-nav-item {{ Request::routeIs('admin.backup.*') ? 'active' : '' }}">
            <i class="bi bi-database-down"></i>
            <span>Backup</span>
        </a>
        @endif

        <form action="{{ route('logout') }}" method="POST" class="mobile-nav-logout-form" onsubmit="return confirm('Apakah yakin ingin keluar?')">
            @csrf
            <button type="submit" class="mobile-nav-item mobile-nav-logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
            </button>
        </form>
    </nav>
    @endauth
    <!--end::Mobile Bottom Navigation-->

    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script
        src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
        integrity="sha256-dghWARbRe2eLlIJ56wNB+b760ywulqK3DzZYEpsg2fQ="
        crossorigin="anonymous"
    ></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"
    ></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    {{-- <script src="../../dist/js/adminlte.js"></script> --}}
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->
    <!-- sortablejs -->
    <script
        src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
        integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ="
        crossorigin="anonymous"
    ></script>
    <!-- sortablejs -->
    <script>
        const connectedSortables = document.querySelectorAll('.connectedSortable');
        connectedSortables.forEach((connectedSortable) => {
            let sortable = new Sortable(connectedSortable, {
                group: 'shared',
                handle: '.card-header',
            });
        });

        const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
        cardHeaders.forEach((cardHeader) => {
            cardHeader.style.cursor = 'move';
        });
    </script>
    <!-- apexcharts -->
    <script
        src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
        integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
        crossorigin="anonymous"
    ></script>
    <!-- ChartJS -->
    <script>
        const sales_chart_options = {
            series: [{
                    name: 'Digital Goods',
                    data: [28, 48, 40, 19, 86, 27, 90],
                },
                {
                    name: 'Electronics',
                    data: [65, 59, 80, 81, 56, 55, 40],
                },
            ],
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            legend: {
                show: false,
            },
            colors: ['#0d6efd', '#20c997'],
            dataLabels: {
                enabled: false,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                type: 'datetime',
                categories: [
                    '2023-01-01',
                    '2023-02-01',
                    '2023-03-01',
                    '2023-04-01',
                    '2023-05-01',
                    '2023-06-01',
                    '2023-07-01',
                ],
            },
            tooltip: {
                x: {
                    format: 'MMMM yyyy',
                },
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector('#revenue-chart'),
            sales_chart_options,
        );
        sales_chart.render();
    </script>
    <!-- jsvectormap -->
    <script
        src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
        crossorigin="anonymous"
    ></script>
    <script
        src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
        crossorigin="anonymous"
    ></script>
    <!-- jsvectormap -->
    <script>
        const visitorsData = {
            US: 398, // USA
            SA: 400, // Saudi Arabia
            CA: 1000, // Canada
            DE: 500, // Germany
            FR: 760, // France
            CN: 300, // China
            AU: 700, // Australia
            BR: 600, // Brazil
            IN: 800, // India
            GB: 320, // Great Britain
            RU: 3000, // Russia
        };

        // World map by jsVectorMap
        const map = new jsVectorMap({
            selector: '#world-map',
            map: 'world',
        });

        // Sparkline charts
        const option_sparkline1 = {
            series: [{
                data: [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline1 = new ApexCharts(document.querySelector('#sparkline-1'), option_sparkline1);
        sparkline1.render();

        const option_sparkline2 = {
            series: [{
                data: [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline2 = new ApexCharts(document.querySelector('#sparkline-2'), option_sparkline2);
        sparkline2.render();

        const option_sparkline3 = {
            series: [{
                data: [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21],
            }, ],
            chart: {
                type: 'area',
                height: 50,
                sparkline: {
                    enabled: true,
                },
            },
            stroke: {
                curve: 'straight',
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0,
            },
            colors: ['#DCE6EC'],
        };

        const sparkline3 = new ApexCharts(document.querySelector('#sparkline-3'), option_sparkline3);
        sparkline3.render();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggler = document.getElementById('sidebarToggler');
            const body = document.body;

            // Create overlay element
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            body.appendChild(overlay);

            // Toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
            }

            // Event listeners
            sidebarToggler.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking outside
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) &&
                    !sidebarToggler.contains(e.target) &&
                    sidebar.classList.contains('show')) {
                    toggleSidebar();
                }
            });

            // Close sidebar on mobile when clicking a link
            const sidebarLinks = sidebar.querySelectorAll('a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        toggleSidebar();
                    }
                });
            });
        });
    </script>
    <!-- Add this at the bottom of your file, before </body> -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <!--end::Script-->
    <!-- At the bottom of your master layout, before </body> -->
    @stack('scripts')

</body>
<!--end::Body-->

</html>
