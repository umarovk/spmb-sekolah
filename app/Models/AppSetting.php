<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    protected $fillable = ['key', 'value'];

    private const CACHE_KEY = 'app_settings.all';
    private const CACHE_TTL = 3600;

    public static function get(string $key, $default = null)
    {
        $all = self::all_cached();
        return $all[$key] ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        self::flush();
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            self::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        self::flush();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    private static function all_cached(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return self::query()->pluck('value', 'key')->toArray();
        });
    }
}
