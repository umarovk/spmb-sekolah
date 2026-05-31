<?php

namespace App\Services;

use App\Models\AppSetting;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class GoogleSheetsService
{
    public const CACHE_KEY              = 'google_sheets.seleksi.rows';
    public const CACHE_KEY_PENDAFTARAN  = 'google_sheets.pendaftaran.rows';

    // ---------- Seleksi (existing) ----------

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

    public function fetchSeleksiRows(bool $forceRefresh = false): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        if ($forceRefresh) {
            Cache::forget(self::CACHE_KEY);
        }

        return Cache::remember(self::CACHE_KEY, $this->cacheTtl(), function () {
            return $this->fetchSheet($this->apiKey(), $this->seleksiId(), $this->seleksiRange())
                ?? ['headers' => [], 'rows' => []];
        });
    }

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

    // ---------- Pendaftaran (new) ----------

    public function pendaftaranApiKey(): ?string
    {
        return AppSetting::get('google_sheets_pendaftaran_api_key')
            ?: config('services.google_sheets.pendaftaran_api_key');
    }

    public function pendaftaranId(): ?string
    {
        return AppSetting::get('google_sheets_pendaftaran_id')
            ?: config('services.google_sheets.pendaftaran_id');
    }

    public function pendaftaranRange(): string
    {
        return AppSetting::get('google_sheets_pendaftaran_range')
            ?: config('services.google_sheets.pendaftaran_range', 'Sheet1');
    }

    /** Returns [gform_header => siswa_field] map. */
    public function pendaftaranMapping(): array
    {
        $json = AppSetting::get('google_sheets_pendaftaran_mapping');
        if (! $json) {
            return [];
        }
        $arr = json_decode($json, true);
        return is_array($arr) ? $arr : [];
    }

    public function isPendaftaranConfigured(): bool
    {
        return filled($this->pendaftaranApiKey()) && filled($this->pendaftaranId());
    }

    public function fetchPendaftaranRows(bool $forceRefresh = false): ?array
    {
        if (! $this->isPendaftaranConfigured()) {
            return null;
        }

        if ($forceRefresh) {
            Cache::forget(self::CACHE_KEY_PENDAFTARAN);
        }

        return Cache::remember(self::CACHE_KEY_PENDAFTARAN, $this->cacheTtl(), function () {
            return $this->fetchSheet(
                $this->pendaftaranApiKey(),
                $this->pendaftaranId(),
                $this->pendaftaranRange()
            ) ?? ['headers' => [], 'rows' => []];
        });
    }

    /**
     * Partial (case-insensitive) name search.
     * Returns array of ['index' => int, 'nama' => string, 'data' => [siswa_field => value]].
     */
    public function searchPendaftaranByName(string $query, int $limit = 10): array
    {
        $data = $this->fetchPendaftaranRows();
        if (! $data || empty($data['headers'])) {
            return [];
        }

        $headers = $data['headers'];
        $mapping = $this->pendaftaranMapping();
        $nameIdx = $this->resolveNameColumnFromMapping($headers, $mapping);

        $needle = $this->normalize($query);
        if ($needle === '') {
            return [];
        }

        $results = [];
        foreach ($data['rows'] as $idx => $row) {
            $cellName = $row[$nameIdx] ?? '';
            if ($cellName === '') {
                continue;
            }
            if (str_contains($this->normalize($cellName), $needle)) {
                $results[] = [
                    'index' => $idx,
                    'nama'  => $cellName,
                    'data'  => $this->transformRow($row, $headers, $mapping),
                ];
                if (count($results) >= $limit) {
                    break;
                }
            }
        }
        return $results;
    }

    private function resolveNameColumnFromMapping(array $headers, array $mapping): int
    {
        foreach ($headers as $i => $h) {
            if (($mapping[$h] ?? null) === 'namasiswa') {
                return $i;
            }
        }
        $fallback = $this->resolveNameColumnIndex($headers);
        return $fallback ?? 0;
    }

    private function transformRow(array $row, array $headers, array $mapping): array
    {
        $out = [];
        foreach ($headers as $i => $h) {
            $field = $mapping[$h] ?? null;
            if (! $field) {
                continue;
            }
            $value = $row[$i] ?? '';
            if (! isset($out[$field]) || $out[$field] === '') {
                $out[$field] = $value;
            }
        }
        return $out;
    }

    // ---------- Shared helpers ----------

    private function resolveNameColumnIndex(array $headers): ?int
    {
        $candidates = ['nama siswa', 'namasiswa', 'nama', 'nama lengkap'];
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
     * Generic fetch: returns ['headers' => [...], 'rows' => [[...], ...]] or null on failure.
     */
    private function fetchSheet(string $apiKey, string $sheetId, string $range): ?array
    {
        $url = sprintf(
            'https://sheets.googleapis.com/v4/spreadsheets/%s/values/%s',
            rawurlencode($sheetId),
            rawurlencode($range)
        );

        try {
            $client = new Client([
                'timeout' => 10,
                'verify' => base_path('ssl-for-api-telegram/cacert.pem'),
            ]);
            $response = $client->get($url, ['query' => ['key' => $apiKey]]);
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
    }

    /**
     * Test connection with given (or current seleksi) credentials without touching cache.
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
            $client   = new Client([
                'timeout' => 10,
                'http_errors' => false,
                'verify' => base_path('ssl-for-api-telegram/cacert.pem'),
            ]);
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
