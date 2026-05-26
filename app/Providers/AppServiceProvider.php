<?php

namespace App\Providers;

use App\Models\AppSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** Konten default halaman login (dipakai kalau admin belum mengisi di Pengaturan). */
    public const LOGIN_DEFAULTS = [
        'description' => 'Aplikasi internal untuk mengelola seluruh tahapan **Penerimaan Murid Baru** — dari pendataan calon siswa, seleksi, pembayaran administrasi, hingga distribusi bahan & rangkuman akhir.',
        'flow_steps'  => [
            'Data calon siswa diinput / ditarik otomatis dari Google Form pendaftaran.',
            '**Selektor** menyeleksi siswa & meninjau jawaban tes.',
            '**Teller** mencatat pembayaran administrasi siswa diterima.',
            '**Selektor / Admin** mendata pengambilan bahan seragam.',
            'Rangkuman SPMB tersedia untuk laporan & monitoring real-time.',
        ],
        'roles' => [
            ['icon' => 'bi-shield-lock-fill',  'name' => 'Admin',    'description' => 'Akses penuh: user, backup, pengaturan, semua data.'],
            ['icon' => 'bi-clipboard-check',   'name' => 'Selektor', 'description' => 'Seleksi siswa, lihat jawaban tes, pengambilan bahan.'],
            ['icon' => 'bi-cash-coin',         'name' => 'Teller',   'description' => 'Mencatat & mengelola pembayaran administrasi.'],
            ['icon' => 'bi-person-badge',      'name' => 'Guest',    'description' => 'Hanya melihat data siswa (read-only).'],
        ],
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                $appName    = AppSetting::get('app_name')    ?: config('app.name', 'SPMB');
                $appTagline = AppSetting::get('app_tagline') ?: 'Sistem Penerimaan Murid Baru';
                $appFavicon = AppSetting::get('app_favicon') ?: 'favicon.ico';

                $loginDesc  = AppSetting::get('login_description');
                $loginFlow  = json_decode((string) AppSetting::get('login_flow_steps'), true);
                $loginRoles = json_decode((string) AppSetting::get('login_roles'), true);
            } catch (\Throwable $e) {
                $appName    = config('app.name', 'SPMB');
                $appTagline = 'Sistem Penerimaan Murid Baru';
                $appFavicon = 'favicon.ico';
                $loginDesc  = null;
                $loginFlow  = null;
                $loginRoles = null;
            }

            $view->with('appBranding', [
                'name'    => $appName,
                'tagline' => $appTagline,
                'favicon' => $appFavicon,
                'login'   => [
                    'description' => filled($loginDesc) ? $loginDesc : self::LOGIN_DEFAULTS['description'],
                    'flow_steps'  => (is_array($loginFlow)  && $loginFlow)  ? $loginFlow  : self::LOGIN_DEFAULTS['flow_steps'],
                    'roles'       => (is_array($loginRoles) && $loginRoles) ? $loginRoles : self::LOGIN_DEFAULTS['roles'],
                ],
            ]);
        });
    }
}
