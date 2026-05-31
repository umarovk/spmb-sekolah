<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Providers\AppServiceProvider;
use App\Services\GoogleSheetsService;
use App\Services\KelengkapanDataService;
use App\Services\TelegramNotifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    /** Field siswa yang bisa di-mapping dari kolom Google Form pendaftaran. */
    public const SISWA_FIELDS = [
        'namasiswa', 'jurusan', 'jeniskelamin', 'agama',
        'tempatlahir', 'tanggallahir', 'tahunmasuk',
        'nik', 'nisn', 'nis', 'nomorsiswa',
        'nomorkip', 'nomorkps', 'nomorkks',
        'kebutuhan_khusus', 'akta_lahir', 'kartu_keluarga',
        'email', 'alamat',
        'sekolah_asal', 'npsn', 'ijazah', 'skhun', 'nomor_ujian_nasional',
        'tinggibadan', 'beratbadan', 'lingkar_kepala', 'transport',
        'jenis_tinggal', 'jumlah_saudara',
        'nama_ayah', 'pendidikan_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
        'alamat_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'nomor_ayah',
        'nama_ibu', 'pendidikan_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
        'alamat_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'nomor_ibu',
        'nama_wali', 'alamat_wali', 'nomor_wali', 'penghasilan_wali',
        'asrama_tahfidz', 'jalurdaftar',
    ];

    public function index(GoogleSheetsService $sheets, KelengkapanDataService $kelengkapan)
    {
        $settings = [
            'google_sheets_api_key'        => AppSetting::get('google_sheets_api_key'),
            'google_sheets_seleksi_id'     => AppSetting::get('google_sheets_seleksi_id'),
            'google_sheets_seleksi_range'  => AppSetting::get('google_sheets_seleksi_range'),
            'google_sheets_cache_ttl'      => AppSetting::get('google_sheets_cache_ttl'),
            'google_sheets_pendaftaran_api_key' => AppSetting::get('google_sheets_pendaftaran_api_key'),
            'google_sheets_pendaftaran_id'      => AppSetting::get('google_sheets_pendaftaran_id'),
            'google_sheets_pendaftaran_range'   => AppSetting::get('google_sheets_pendaftaran_range'),
            'app_name'    => AppSetting::get('app_name'),
            'app_tagline' => AppSetting::get('app_tagline'),
            'app_favicon' => AppSetting::get('app_favicon'),
            'login_description' => AppSetting::get('login_description'),
            'login_flow_steps'  => AppSetting::get('login_flow_steps'),
            'login_roles'       => AppSetting::get('login_roles'),
            'telegram_bot_token'      => AppSetting::get('telegram_bot_token'),
            'telegram_chat_id'        => AppSetting::get('telegram_chat_id'),
            'telegram_enabled'        => AppSetting::get('telegram_enabled'),
            'telegram_notify_siswa'   => AppSetting::get('telegram_notify_siswa'),
            'telegram_notify_payment' => AppSetting::get('telegram_notify_payment'),
        ];

        // Decode untuk preview / form
        $loginFlowArr  = json_decode((string) $settings['login_flow_steps'], true);
        $loginRolesArr = json_decode((string) $settings['login_roles'], true);
        if (! is_array($loginFlowArr)  || empty($loginFlowArr))  $loginFlowArr  = AppServiceProvider::LOGIN_DEFAULTS['flow_steps'];
        if (! is_array($loginRolesArr) || empty($loginRolesArr)) $loginRolesArr = AppServiceProvider::LOGIN_DEFAULTS['roles'];

        $loginContent = [
            'description' => $settings['login_description'] ?: AppServiceProvider::LOGIN_DEFAULTS['description'],
            'flow_steps'  => $loginFlowArr,
            'roles'       => $loginRolesArr,
            'defaults'    => AppServiceProvider::LOGIN_DEFAULTS,
        ];

        $envFallback = [
            'api_key'              => config('services.google_sheets.api_key'),
            'seleksi_id'           => config('services.google_sheets.seleksi_id'),
            'range'                => config('services.google_sheets.seleksi_range', 'Sheet1'),
            'cache_ttl'            => (int) config('services.google_sheets.cache_ttl', 300),
            'pendaftaran_api_key'  => config('services.google_sheets.pendaftaran_api_key'),
            'pendaftaran_id'       => config('services.google_sheets.pendaftaran_id'),
            'pendaftaran_range'    => config('services.google_sheets.pendaftaran_range', 'Sheet1'),
        ];

        return view('admin.settings.index', [
            'settings'    => $settings,
            'envFallback' => $envFallback,
            'effective'   => [
                'api_key'                => $sheets->apiKey(),
                'seleksi_id'             => $sheets->seleksiId(),
                'range'                  => $sheets->seleksiRange(),
                'cache_ttl'              => $sheets->cacheTtl(),
                'configured'             => $sheets->isConfigured(),
                'pendaftaran_configured' => $sheets->isPendaftaranConfigured(),
            ],
            'pendaftaranMapping' => $sheets->pendaftaranMapping(),
            'siswaFields'        => self::SISWA_FIELDS,
            'loginContent'       => $loginContent,
            'requiredFields'     => $kelengkapan->requiredFields(),
            'fieldGroups'        => KelengkapanDataService::FIELD_GROUPS,
            'fieldLabels'        => KelengkapanDataService::FIELD_LABELS,
            'defaultRequired'    => KelengkapanDataService::DEFAULT_REQUIRED,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'google_sheets_api_key'             => ['nullable', 'string', 'max:255'],
            'google_sheets_seleksi_id'          => ['nullable', 'string', 'max:255'],
            'google_sheets_seleksi_range'       => ['nullable', 'string', 'max:255'],
            'google_sheets_cache_ttl'           => ['nullable', 'integer', 'min:0', 'max:86400'],
            'google_sheets_pendaftaran_api_key' => ['nullable', 'string', 'max:255'],
            'google_sheets_pendaftaran_id'      => ['nullable', 'string', 'max:255'],
            'google_sheets_pendaftaran_range'   => ['nullable', 'string', 'max:255'],
            'mapping'                           => ['nullable', 'array'],
            'mapping.*'                         => ['nullable', 'string', 'max:64'],
            'app_name'    => ['nullable', 'string', 'max:100'],
            'app_tagline' => ['nullable', 'string', 'max:200'],
            'app_favicon' => ['nullable', 'file', 'mimes:png,jpg,jpeg,ico,svg,webp', 'max:512'],
            'app_favicon_reset' => ['nullable', 'in:1'],
            'login_description'        => ['nullable', 'string', 'max:1000'],
            'login_flow_steps'         => ['nullable', 'string', 'max:2000'],
            'login_roles_icon'         => ['nullable', 'array'],
            'login_roles_icon.*'       => ['nullable', 'string', 'max:60'],
            'login_roles_name'         => ['nullable', 'array'],
            'login_roles_name.*'       => ['nullable', 'string', 'max:50'],
            'login_roles_description'  => ['nullable', 'array'],
            'login_roles_description.*'=> ['nullable', 'string', 'max:200'],
            'login_reset'              => ['nullable', 'in:1'],
            'required_siswa_fields'   => ['nullable', 'array'],
            'required_siswa_fields.*' => ['string', 'max:64'],
            'required_reset'          => ['nullable', 'in:1'],
            'telegram_bot_token'      => ['nullable', 'string', 'max:255'],
            'telegram_chat_id'        => ['nullable', 'string', 'max:64'],
            'telegram_enabled'        => ['nullable', 'in:1'],
            'telegram_notify_siswa'   => ['nullable', 'in:1'],
            'telegram_notify_payment' => ['nullable', 'in:1'],
        ]);

        // Field wajib siswa (cek kelengkapan data)
        if ($request->boolean('required_reset')) {
            $requiredToSave = null;
        } else {
            $req = array_values(array_intersect(
                (array) ($validated['required_siswa_fields'] ?? []),
                array_keys(KelengkapanDataService::FIELD_LABELS)
            ));
            $requiredToSave = $req ? json_encode($req, JSON_UNESCAPED_UNICODE) : null;
        }

        // Parse flow steps (satu baris = satu langkah)
        $flowStepsRaw = (string) ($validated['login_flow_steps'] ?? '');
        $flowSteps = collect(preg_split('/\r\n|\r|\n/', $flowStepsRaw))
            ->map(fn ($s) => trim($s))
            ->filter(fn ($s) => $s !== '')
            ->values()
            ->all();

        // Parse roles (paralel arrays)
        $rolesIcon = $request->input('login_roles_icon', []);
        $rolesName = $request->input('login_roles_name', []);
        $rolesDesc = $request->input('login_roles_description', []);
        $roles = [];
        $count = max(count((array) $rolesIcon), count((array) $rolesName), count((array) $rolesDesc));
        for ($i = 0; $i < $count; $i++) {
            $name = trim((string) ($rolesName[$i] ?? ''));
            $desc = trim((string) ($rolesDesc[$i] ?? ''));
            $icon = trim((string) ($rolesIcon[$i] ?? ''));
            if ($name === '' && $desc === '') {
                continue; // baris kosong, skip
            }
            $roles[] = [
                'icon'        => $icon !== '' ? $icon : 'bi-person',
                'name'        => $name,
                'description' => $desc,
            ];
        }

        // Reset konten login ke default
        if ($request->boolean('login_reset')) {
            $loginDescriptionToSave = null;
            $loginFlowToSave        = null;
            $loginRolesToSave       = null;
        } else {
            $loginDescriptionToSave = filled($validated['login_description'] ?? null)
                ? $validated['login_description']
                : null;
            $loginFlowToSave  = $flowSteps ? json_encode($flowSteps, JSON_UNESCAPED_UNICODE) : null;
            $loginRolesToSave = $roles ? json_encode($roles, JSON_UNESCAPED_UNICODE) : null;
        }

        $mapping = [];
        foreach (($validated['mapping'] ?? []) as $header => $field) {
            $header = trim((string) $header);
            $field  = trim((string) $field);
            if ($header === '' || $field === '' || ! in_array($field, self::SISWA_FIELDS, true)) {
                continue;
            }
            $mapping[$header] = $field;
        }

        // Handle favicon upload / reset
        $faviconPath = AppSetting::get('app_favicon');
        if ($request->boolean('app_favicon_reset')) {
            $this->deleteFaviconFile($faviconPath);
            $faviconPath = null;
        } elseif ($request->hasFile('app_favicon')) {
            $this->deleteFaviconFile($faviconPath);
            $file = $request->file('app_favicon');
            $ext  = strtolower($file->getClientOriginalExtension() ?: 'png');
            $name = 'favicon-' . time() . '.' . $ext;
            $dest = public_path('branding');
            if (! is_dir($dest)) {
                @mkdir($dest, 0775, true);
            }
            $file->move($dest, $name);
            $faviconPath = 'branding/' . $name;
        }

        AppSetting::setMany([
            'google_sheets_api_key'             => $validated['google_sheets_api_key']             ?? null,
            'google_sheets_seleksi_id'          => $validated['google_sheets_seleksi_id']          ?? null,
            'google_sheets_seleksi_range'       => $validated['google_sheets_seleksi_range']       ?? null,
            'google_sheets_cache_ttl'           => isset($validated['google_sheets_cache_ttl'])
                ? (string) $validated['google_sheets_cache_ttl']
                : null,
            'google_sheets_pendaftaran_api_key' => $validated['google_sheets_pendaftaran_api_key'] ?? null,
            'google_sheets_pendaftaran_id'      => $validated['google_sheets_pendaftaran_id']      ?? null,
            'google_sheets_pendaftaran_range'   => $validated['google_sheets_pendaftaran_range']   ?? null,
            'google_sheets_pendaftaran_mapping' => $mapping ? json_encode($mapping, JSON_UNESCAPED_UNICODE) : null,
            'app_name'    => $validated['app_name']    ?? null,
            'app_tagline' => $validated['app_tagline'] ?? null,
            'app_favicon' => $faviconPath,
            'login_description' => $loginDescriptionToSave,
            'login_flow_steps'  => $loginFlowToSave,
            'login_roles'       => $loginRolesToSave,
            KelengkapanDataService::SETTING_KEY => $requiredToSave,
            'telegram_bot_token'      => $validated['telegram_bot_token']      ?? null,
            'telegram_chat_id'        => $validated['telegram_chat_id']        ?? null,
            'telegram_enabled'        => $request->boolean('telegram_enabled') ? '1' : null,
            'telegram_notify_siswa'   => $request->boolean('telegram_notify_siswa') ? '1' : null,
            'telegram_notify_payment' => $request->boolean('telegram_notify_payment') ? '1' : null,
        ]);

        AppSetting::flush();
        Cache::forget(GoogleSheetsService::CACHE_KEY);
        Cache::forget(GoogleSheetsService::CACHE_KEY_PENDAFTARAN);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }

    private function deleteFaviconFile(?string $relativePath): void
    {
        if (! $relativePath) {
            return;
        }
        // Hanya hapus file di dalam folder branding/ (cegah path traversal)
        if (! str_starts_with($relativePath, 'branding/')) {
            return;
        }
        $full = public_path($relativePath);
        if (is_file($full)) {
            @unlink($full);
        }
    }

    public function testSheets(Request $request, GoogleSheetsService $sheets)
    {
        $request->validate([
            'api_key'    => ['nullable', 'string'],
            'seleksi_id' => ['nullable', 'string'],
            'range'      => ['nullable', 'string'],
        ]);

        $result = $sheets->testConnection(
            $request->input('api_key')    ?: null,
            $request->input('seleksi_id') ?: null,
            $request->input('range')      ?: null,
        );

        return response()->json($result);
    }

    public function testTelegram(Request $request, TelegramNotifier $telegram)
    {
        $request->validate([
            'token'    => ['nullable', 'string', 'max:255'],
            'chat_id'  => ['nullable', 'string', 'max:64'],
        ]);

        $token  = $request->input('token')   ?: $telegram->token();
        $chatId = $request->input('chat_id') ?: $telegram->chatId();

        if (! $token || ! $chatId) {
            return response()->json(['ok' => false, 'message' => 'Bot token & chat ID harus diisi.']);
        }

        $appName = AppSetting::get('app_name') ?: 'SPMB Sekolah';
        $now = now('Asia/Jakarta')->translatedFormat('d F Y, H:i') . ' WIB';
        $text = "✅ <b>Test Notifikasi Telegram</b>\n<i>{$appName}</i>\n\nKoneksi berhasil. Notifikasi otomatis siap digunakan.\n\n🕐 {$now}";

        $result = $telegram->sendMessage($text, $token, $chatId);
        return response()->json($result);
    }

    /**
     * Fetch headers from current pendaftaran sheet creds (for mapping UI).
     */
    public function fetchPendaftaranHeaders(Request $request, GoogleSheetsService $sheets)
    {
        $request->validate([
            'api_key'  => ['nullable', 'string'],
            'sheet_id' => ['nullable', 'string'],
            'range'    => ['nullable', 'string'],
        ]);

        $result = $sheets->testConnection(
            $request->input('api_key')  ?: $sheets->pendaftaranApiKey(),
            $request->input('sheet_id') ?: $sheets->pendaftaranId(),
            $request->input('range')    ?: $sheets->pendaftaranRange(),
        );

        return response()->json($result);
    }
}
