<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0a4fb8">
    <meta name="robots" content="noindex,nofollow">
    <meta name="google" content="notranslate">

    @php
        $brandName    = $appBranding['name']    ?? 'SPMB';
        $brandTagline = $appBranding['tagline'] ?? 'Sistem Penerimaan Murid Baru';
        $faviconPath  = $appBranding['favicon'] ?? 'favicon.ico';
        $faviconAbs   = public_path($faviconPath);
        $faviconVer   = (is_file($faviconAbs) ? filemtime($faviconAbs) : 1);
        $schoolLogo   = asset(config('app.school_logo', 'img/user.png'));

        $loginDesc  = $appBranding['login']['description'] ?? '';
        $loginFlow  = $appBranding['login']['flow_steps']  ?? [];
        $loginRoles = $appBranding['login']['roles']       ?? [];

        // Mini-formatter: escape HTML lalu izinkan **bold** -> <strong>bold</strong>
        $fmt = function (?string $s): string {
            if ($s === null) return '';
            $escaped = e($s);
            return preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $escaped);
        };
    @endphp

    <title>Login &mdash; {{ $brandName }}</title>
    <link rel="icon" href="{{ asset($faviconPath) }}?v={{ $faviconVer }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand: #0d6efd;
            --brand-dark: #0a4fb8;
            --ink: #0f172a;
            --muted: #64748b;
            --line: #e2e8f0;
        }
        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            color: var(--ink);
            background: #fff;
            -webkit-font-smoothing: antialiased;
        }

        /* ================== Layout ================== */
        .login-shell {
            min-height: 100vh;
            min-height: 100dvh;
            display: flex;
            flex-direction: row;
        }

        /* ===== Panel kiri: Info ===== */
        .login-info {
            flex: 1.05 1 0;
            background:
                radial-gradient(circle at 15% 10%, rgba(255,255,255,0.18) 0, transparent 35%),
                radial-gradient(circle at 90% 90%, rgba(0,0,0,0.18) 0, transparent 40%),
                linear-gradient(160deg, #0a4fb8 0%, #0d6efd 55%, #3a8dff 100%);
            color: #fff;
            padding: clamp(28px, 5vw, 64px);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .login-info::before,
        .login-info::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }
        .login-info::before {
            top: -120px; right: -100px;
            width: 360px; height: 360px;
            background: rgba(255,255,255,0.07);
        }
        .login-info::after {
            bottom: -140px; left: -80px;
            width: 320px; height: 320px;
            background: rgba(255,255,255,0.05);
        }
        .login-info-inner {
            position: relative;
            max-width: 560px;
            margin: auto 0;
            width: 100%;
        }
        .brand-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }
        .brand-logo {
            width: 56px; height: 56px;
            background: #fff;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.18);
            flex-shrink: 0;
        }
        .brand-logo img { width: 40px; height: 40px; object-fit: contain; border-radius: 8px; }
        .brand-title {
            font-size: clamp(1.4rem, 2.2vw, 1.75rem);
            font-weight: 700;
            margin: 0;
            line-height: 1.15;
            letter-spacing: -0.3px;
        }
        .brand-tag {
            font-size: 0.9rem;
            opacity: 0.85;
            margin-top: 2px;
        }
        .lead-desc {
            font-size: clamp(0.95rem, 1.15vw, 1.05rem);
            line-height: 1.6;
            opacity: 0.95;
            margin: 0 0 26px;
            max-width: 52ch;
        }
        .section-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 1.4px;
            font-weight: 600;
            opacity: 0.78;
            margin: 26px 0 12px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .flow-list {
            list-style: none;
            padding: 0;
            margin: 0 0 8px 0;
            counter-reset: step;
        }
        .flow-list li {
            position: relative;
            padding: 9px 0 9px 40px;
            font-size: 0.92rem;
            line-height: 1.5;
            counter-increment: step;
        }
        .flow-list li::before {
            content: counter(step);
            position: absolute;
            left: 0; top: 8px;
            width: 26px; height: 26px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.32);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.74rem;
            font-weight: 700;
        }
        .role-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .role-pill {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 0.85rem;
            line-height: 1.45;
            backdrop-filter: blur(4px);
        }
        .role-pill .role-name {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            margin-bottom: 3px;
        }
        .role-pill .role-name i { font-size: 1rem; }
        .role-pill .role-desc { opacity: 0.85; font-size: 0.78rem; }

        /* ===== Panel kanan: Form ===== */
        .login-form-wrap {
            flex: 1 1 0;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(28px, 5vw, 64px);
            position: relative;
        }
        .login-form {
            width: 100%;
            max-width: 420px;
        }
        .login-form h2 {
            font-weight: 700;
            font-size: clamp(1.4rem, 2vw, 1.7rem);
            margin: 0 0 6px;
            color: var(--ink);
            letter-spacing: -0.3px;
        }
        .login-form .subtitle {
            color: var(--muted);
            font-size: 0.95rem;
            margin-bottom: 28px;
        }
        .form-floating > .form-control {
            border-radius: 12px;
            border: 1px solid var(--line);
            background: #f8fafc;
            transition: all 0.15s ease;
            height: 58px;
        }
        .form-floating > .form-control:focus {
            background: #fff;
            border-color: var(--brand);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
        }
        .form-floating > label { color: var(--muted); }

        .btn-login {
            background: linear-gradient(135deg, #0d6efd 0%, #0a4fb8 100%);
            color: #fff;
            border: 0;
            border-radius: 12px;
            padding: 13px 18px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: transform 0.15s ease, box-shadow 0.2s ease, filter 0.2s ease;
            width: 100%;
            box-shadow: 0 10px 24px -10px rgba(13, 110, 253, 0.55);
            font-size: 1rem;
        }
        .btn-login:hover { transform: translateY(-1px); box-shadow: 0 14px 32px -10px rgba(13, 110, 253, 0.65); color: #fff; }
        .btn-login:active { transform: translateY(0); filter: brightness(0.97); }

        .pwd-toggle {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            background: transparent;
            border: 0;
            padding: 8px 10px;
            cursor: pointer;
            z-index: 4;
        }
        .pwd-toggle:hover { color: var(--brand); }

        .alert-soft {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 0.9rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }
        .login-foot {
            text-align: center;
            color: #94a3b8;
            font-size: 0.78rem;
            margin-top: 28px;
        }

        /* ================== Mobile brand (atas form) ================== */
        .mobile-brand {
            display: none;
            text-align: center;
            margin-bottom: 24px;
        }
        .mobile-brand .brand-logo {
            margin: 0 auto 12px;
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #0d6efd, #0a4fb8);
            box-shadow: 0 12px 28px -8px rgba(13, 110, 253, 0.55);
        }
        .mobile-brand .brand-logo img { width: 42px; height: 42px; }
        .mobile-brand h1 {
            font-size: 1.45rem;
            font-weight: 700;
            margin: 0;
            color: var(--ink);
            letter-spacing: -0.3px;
        }
        .mobile-brand .brand-tag {
            color: var(--muted);
            font-size: 0.88rem;
            margin-top: 4px;
        }

        /* ================== Info Toggle (mobile) ================== */
        .info-toggle {
            display: none;
            margin-top: 24px;
            width: 100%;
            text-align: center;
            padding: 12px;
            border: 1px dashed var(--line);
            background: transparent;
            color: var(--muted);
            border-radius: 12px;
            font-size: 0.88rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .info-toggle:hover { color: var(--brand); border-color: var(--brand); background: rgba(13, 110, 253, 0.04); }
        .info-toggle i { transition: transform 0.2s ease; }
        .info-toggle[aria-expanded="true"] i { transform: rotate(180deg); }

        /* ================== Responsive: <=900px (tablet & mobile) ================== */
        @media (max-width: 900px) {
            .login-shell {
                flex-direction: column;
                min-height: 100vh;
                min-height: 100dvh;
            }
            .login-info {
                /* di mobile, panel info ada DI BAWAH form (collapsible) */
                order: 2;
                padding: 28px 22px 36px;
                flex: 0 0 auto;
            }
            .login-info-inner { max-width: 100%; margin: 0; }
            .login-info::before { top: -80px; right: -60px; width: 220px; height: 220px; }
            .login-info::after { bottom: -100px; left: -50px; width: 220px; height: 220px; }
            .brand-wrap { display: none; } /* sembunyikan duplikat brand di panel info */
            .login-form-wrap {
                order: 1;
                flex: 1 1 auto;
                padding: 36px 22px 16px;
                background: #fff;
            }
            .mobile-brand { display: block; }
            .info-toggle { display: flex; align-items: center; justify-content: center; gap: 8px; }
            .login-info {
                display: none;
            }
            .login-info.is-open { display: flex; }
        }

        /* ================== Sangat kecil (<360px) ================== */
        @media (max-width: 360px) {
            .role-grid { grid-template-columns: 1fr; }
            .login-form-wrap { padding: 28px 16px 12px; }
            .login-info { padding: 24px 16px 32px; }
        }
    </style>
</head>

<body>
    <main class="login-shell">

        {{-- ===== Form Panel (kanan di desktop, atas di mobile) ===== --}}
        <section class="login-form-wrap">
            <div class="login-form">

                {{-- Brand kompak (hanya tampil di mobile) --}}
                <div class="mobile-brand">
                    <div class="brand-logo">
                        <img src="{{ $schoolLogo }}" alt="Logo" onerror="this.src='{{ asset('img/user.png') }}'">
                    </div>
                    <h1>{{ $brandName }}</h1>
                    <div class="brand-tag">{{ $brandTagline }}</div>
                </div>

                <h2>Masuk ke akun Anda</h2>
                <div class="subtitle">Gunakan username/email & password yang diberikan oleh Admin.</div>

                @if ($errors->any())
                    <div class="alert-soft mb-3" role="alert">
                        <i class="bi bi-exclamation-circle-fill mt-1"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" autocomplete="off" novalidate>
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text"
                               class="form-control @error('login') is-invalid @enderror"
                               id="login"
                               name="login"
                               placeholder="Username atau Email"
                               value="{{ old('login') }}"
                               required autofocus autocomplete="off"
                               inputmode="email">
                        <label for="login"><i class="bi bi-person me-1"></i> Username / Email</label>
                    </div>

                    <div class="form-floating mb-3 position-relative">
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Password"
                               required autocomplete="new-password">
                        <label for="password"><i class="bi bi-lock me-1"></i> Password</label>
                        <button type="button" class="pwd-toggle" id="togglePwd" tabindex="-1" aria-label="Tampilkan password">
                            <i class="bi bi-eye" id="togglePwdIcon"></i>
                        </button>
                    </div>

                    <button type="submit" class="btn-login mt-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                    </button>
                </form>

                {{-- Tombol toggle info (hanya mobile) --}}
                @if (filled($loginDesc) || count($loginFlow) || count($loginRoles))
                    <button type="button"
                            class="info-toggle"
                            id="infoToggle"
                            aria-expanded="false"
                            aria-controls="loginInfo">
                        <i class="bi bi-chevron-down"></i>
                        <span>Tentang aplikasi ini</span>
                    </button>
                @endif

                <div class="login-foot">
                    &copy; {{ date('Y') }} {{ $brandName }} &middot; v1.0
                </div>
            </div>
        </section>

        {{-- ===== Info Panel (kiri di desktop, bawah & collapsible di mobile) ===== --}}
        <aside class="login-info" id="loginInfo">
            <div class="login-info-inner">

                <div class="brand-wrap">
                    <div class="brand-logo">
                        <img src="{{ $schoolLogo }}" alt="Logo" onerror="this.src='{{ asset('img/user.png') }}'">
                    </div>
                    <div>
                        <h1 class="brand-title">{{ $brandName }}</h1>
                        <div class="brand-tag">{{ $brandTagline }}</div>
                    </div>
                </div>

                @if (filled($loginDesc))
                    <p class="lead-desc">{!! $fmt($loginDesc) !!}</p>
                @endif

                @if (count($loginFlow))
                    <div class="section-title"><i class="bi bi-diagram-3"></i> Alur Aplikasi</div>
                    <ol class="flow-list">
                        @foreach ($loginFlow as $step)
                            <li>{!! $fmt($step) !!}</li>
                        @endforeach
                    </ol>
                @endif

                @if (count($loginRoles))
                    <div class="section-title"><i class="bi bi-people"></i> Role Pengguna</div>
                    <div class="role-grid">
                        @foreach ($loginRoles as $role)
                            <div class="role-pill">
                                <div class="role-name">
                                    <i class="bi {{ $role['icon'] ?? 'bi-person' }}"></i> {{ $role['name'] ?? '' }}
                                </div>
                                @if (filled($role['description'] ?? null))
                                    <div class="role-desc">{{ $role['description'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </aside>

    </main>

    <script>
        (function () {
            // Toggle password
            var btn = document.getElementById('togglePwd');
            var pwd = document.getElementById('password');
            var icon = document.getElementById('togglePwdIcon');
            if (btn && pwd) {
                btn.addEventListener('click', function () {
                    var isPwd = pwd.type === 'password';
                    pwd.type = isPwd ? 'text' : 'password';
                    icon.className = isPwd ? 'bi bi-eye-slash' : 'bi bi-eye';
                });
            }

            // Toggle info (mobile)
            var infoToggle = document.getElementById('infoToggle');
            var infoPanel  = document.getElementById('loginInfo');
            if (infoToggle && infoPanel) {
                infoToggle.addEventListener('click', function () {
                    var isOpen = infoPanel.classList.toggle('is-open');
                    infoToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                    infoToggle.querySelector('span').textContent =
                        isOpen ? 'Sembunyikan info' : 'Tentang aplikasi ini';
                    if (isOpen) {
                        infoPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }
        })();
    </script>
</body>

</html>
