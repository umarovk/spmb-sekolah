<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Services\GoogleSheetsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index(GoogleSheetsService $sheets)
    {
        $settings = [
            'google_sheets_api_key'        => AppSetting::get('google_sheets_api_key'),
            'google_sheets_seleksi_id'     => AppSetting::get('google_sheets_seleksi_id'),
            'google_sheets_seleksi_range'  => AppSetting::get('google_sheets_seleksi_range'),
            'google_sheets_cache_ttl'      => AppSetting::get('google_sheets_cache_ttl'),
        ];

        $envFallback = [
            'api_key'    => config('services.google_sheets.api_key'),
            'seleksi_id' => config('services.google_sheets.seleksi_id'),
            'range'      => config('services.google_sheets.seleksi_range', 'Sheet1'),
            'cache_ttl'  => (int) config('services.google_sheets.cache_ttl', 300),
        ];

        return view('admin.settings.index', [
            'settings'    => $settings,
            'envFallback' => $envFallback,
            'effective'   => [
                'api_key'    => $sheets->apiKey(),
                'seleksi_id' => $sheets->seleksiId(),
                'range'      => $sheets->seleksiRange(),
                'cache_ttl'  => $sheets->cacheTtl(),
                'configured' => $sheets->isConfigured(),
            ],
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'google_sheets_api_key'       => ['nullable', 'string', 'max:255'],
            'google_sheets_seleksi_id'    => ['nullable', 'string', 'max:255'],
            'google_sheets_seleksi_range' => ['nullable', 'string', 'max:255'],
            'google_sheets_cache_ttl'     => ['nullable', 'integer', 'min:0', 'max:86400'],
        ]);

        AppSetting::setMany([
            'google_sheets_api_key'       => $validated['google_sheets_api_key']       ?? null,
            'google_sheets_seleksi_id'    => $validated['google_sheets_seleksi_id']    ?? null,
            'google_sheets_seleksi_range' => $validated['google_sheets_seleksi_range'] ?? null,
            'google_sheets_cache_ttl'     => isset($validated['google_sheets_cache_ttl'])
                ? (string) $validated['google_sheets_cache_ttl']
                : null,
        ]);

        AppSetting::flush();
        Cache::forget(GoogleSheetsService::CACHE_KEY);

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
}
