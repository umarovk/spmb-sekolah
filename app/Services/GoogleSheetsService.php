<?php

namespace App\Services;

use App\Models\AppSetting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleSheetsService
{
    public const CACHE_KEY = 'google_sheets.seleksi.rows';

    /** DB-overridable settings (DB value > .env). */
    public function apiKey(): ?string
    {
        return AppSetting::get('google_sheets_api_key') ?: config('services.google_sheets.api_key');
    }

    public function seleksiId(): ?string
    {
        return AppSetting::get('google_sheets_seleksi_id') ?: config('services.google_sheets.seleksi_id');
    }

    public function seleksiRange(): string
    {
        return AppSetting::get('google_sheets_seleksi_range')
            ?: config('services.google_sheets.seleksi_range', 'Sheet1');
    }

    public function cacheTtl(): int
    {
        $dbVal = AppSetting::get('google_sheets_cache_ttl');
        if ($dbVal !== null && $dbVal !== '') {
            return (int) $dbVal;
        }
        return (int) config('services.google_sheets.cache_ttl', 300);
    }

    public function isConfigured(): bool
    {
        return filled($this->apiKey()) && filled($this->seleksiId());
    }

    /**
     * Fetch raw rows from the configured spreadsheet.
     * Returns ['headers' => [...], 'rows' => [[...], ...]] or null on failure.
     */
    public function fetchSeleksiRows(bool $forceRefresh = false): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        $ttl = $this->cacheTtl();

        if ($forceRefresh) {
            Cache::forget(self::CACHE_KEY);
        }

        return Cache::remember(self::CACHE_KEY, $ttl, function () {
            $sheetId = $this->seleksiId();
            $range   = $this->seleksiRange();
            $apiKey  = $this->apiKey();

            $url = sprintf(
                'https://sheets.googleapis.com/v4/spreadsheets/%s/values/%s',
                rawurlencode($sheetId),
                rawurlencode($range)
            );

            try {
                $client = new Client(['timeout' => 10]);
                $response = $client->get($url, [
                    'query' => ['key' => $apiKey],
                ]);
                $body = json_decode((string) $response->getBody(), true);
            } catch (GuzzleException $e) {
                Log::warning('GoogleSheets fetch failed: ' . $e->getMessage());
                return null;
            }

            $values = $body['values'] ?? [];
            if (count($values) < 1) {
                return ['headers' => [], 'rows' => []];
            }

            $headers = array_map(fn ($h) => trim((string) $h), array_shift($values));
            $rows = array_map(fn ($row) => array_map(fn ($cell) => (string) $cell, $row), $values);

            return ['headers' => $headers, 'rows' => $rows];
        });
    }

    /**
     * Find the answer row for a given student name (case-insensitive, trimmed).
     * Returns ['nama' => string, 'answers' => ['Header' => 'Value', ...]] or null.
     */
    public function findByStudentName(string $namaSiswa): ?array
    {
        $data = $this->fetchSeleksiRows();
        if (! $data || empty($data['headers'])) {
            return null;
        }

        $headers = $data['headers'];
        $nameColumnIndex = $this->resolveNameColumnIndex($headers);
        if ($nameColumnIndex === null) {
            return null;
        }

        $needle = $this->normalize($namaSiswa);

        foreach ($data['rows'] as $row) {
            $cellName = $row[$nameColumnIndex] ?? '';
            if ($this->normalize($cellName) === $needle) {
                $answers = [];
                foreach ($headers as $i => $header) {
                    if ($i === $nameColumnIndex || $header === '') {
                        continue;
                    }
                    $answers[$header] = $row[$i] ?? '';
                }
                return [
                    'nama'    => $cellName,
                    'answers' => $answers,
                ];
            }
        }

        return null;
    }

    private function resolveNameColumnIndex(array $headers): ?int
    {
        $candidates = ['nama siswa', 'namasiswa', 'nama'];
        foreach ($headers as $i => $header) {
            $normalized = $this->normalize($header);
            if (in_array($normalized, $candidates, true)) {
                return $i;
            }
        }
        return 0;
    }

    private function normalize(string $value): string
    {
        return strtolower(trim(preg_replace('/\s+/', ' ', $value)));
    }

    /**
     * Test connection with given (or current) credentials without touching the cache.
     * Returns ['ok' => bool, 'message' => string, 'sample' => array|null].
     */
    public function testConnection(?string $apiKey = null, ?string $sheetId = null, ?string $range = null): array
    {
        $apiKey  = $apiKey  ?: $this->apiKey();
        $sheetId = $sheetId ?: $this->seleksiId();
        $range   = $range   ?: $this->seleksiRange();

        if (! $apiKey || ! $sheetId) {
            return ['ok' => false, 'message' => 'API Key dan Spreadsheet ID wajib diisi.', 'sample' => null];
        }

        $url = sprintf(
            'https://sheets.googleapis.com/v4/spreadsheets/%s/values/%s',
            rawurlencode($sheetId),
            rawurlencode($range)
        );

        try {
            $client   = new Client(['timeout' => 10, 'http_errors' => false]);
            $response = $client->get($url, ['query' => ['key' => $apiKey]]);
            $status   = $response->getStatusCode();
            $body     = json_decode((string) $response->getBody(), true);

            if ($status !== 200) {
                $err = $body['error']['message'] ?? 'HTTP ' . $status;
                return ['ok' => false, 'message' => 'Gagal: ' . $err, 'sample' => null];
            }

            $values = $body['values'] ?? [];
            $headers = $values[0] ?? [];
            $totalRows = max(0, count($values) - 1);

            return [
                'ok'      => true,
                'message' => "Berhasil — {$totalRows} baris data, " . count($headers) . " kolom.",
                'sample'  => ['headers' => $headers, 'first_row' => $values[1] ?? []],
            ];
        } catch (GuzzleException $e) {
            Log::warning('GoogleSheets testConnection failed: ' . $e->getMessage());
            return ['ok' => false, 'message' => 'Error koneksi: ' . $e->getMessage(), 'sample' => null];
        }
    }
}
