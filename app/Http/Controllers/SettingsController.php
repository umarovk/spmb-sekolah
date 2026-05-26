<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Services\GoogleSheetsService;
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
        'tinggibadan', 'beratbadan', 'transport',
        'jenis_tinggal', 'jumlah_saudara',
        'nama_ayah', 'pendidikan_ayah', 'tempat_lahir_ayah', 'tanggal_lahir_ayah',
        'alamat_ayah', 'pekerjaan_ayah', 'penghasilan_ayah', 'nomor_ayah',
        'nama_ibu', 'pendidikan_ibu', 'tempat_lahir_ibu', 'tanggal_lahir_ibu',
        'alamat_ibu', 'pekerjaan_ibu', 'penghasilan_ibu', 'nomor_ibu',
        'nama_wali', 'alamat_wali', 'nomor_wali', 'penghasilan_wali',
        'asrama_tahfidz', 'jalurdaftar',
    ];

    public function index(GoogleSheetsService $sheets)
    {
        $settings = [
            'google_sheets_api_key'        => AppSetting::get('google_sheets_api_key'),
            'google_sheets_seleksi_id'     => AppSetting::get('google_sheets_seleksi_id'),
            'google_sheets_seleksi_range'  => AppSetting::get('google_sheets_seleksi_range'),
            'google_sheets_cache_ttl'      => AppSetting::get('google_sheets_cache_ttl'),
            'google_sheets_pendaftaran_api_key' => AppSetting::get('google_sheets_pendaftaran_api_key'),
            'google_sheets_pendaftaran_id'      => AppSetting::get('google_sheets_pendaftaran_id'),
            'google_sheets_pendaftaran_range'   => AppSetting::get('google_sheets_pendaftaran_range'),
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
        ]);

        $mapping = [];
        foreach (($validated['mapping'] ?? []) as $header => $field) {
            $header = trim((string) $header);
            $field  = trim((string) $field);
            if ($header === '' || $field === '' || ! in_array($field, self::SISWA_FIELDS, true)) {
                continue;
            }
            $mapping[$header] = $field;
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
        ]);

        AppSetting::flush();
        Cache::forget(GoogleSheetsService::CACHE_KEY);
        Cache::forget(GoogleSheetsService::CACHE_KEY_PENDAFTARAN);

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil disimpan.');
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
