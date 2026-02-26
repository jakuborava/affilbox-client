<?php

namespace JakubOrava\AffilboxClient\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;

trait ArrayHelpers
{
    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getString(array $data, string $key, string $default = ''): string
    {
        return (string) ($data[$key] ?? $default);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getInt(array $data, string $key, int $default = 0): int
    {
        return (int) ($data[$key] ?? $default);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getFloat(array $data, string $key, float $default = 0.0): float
    {
        return (float) ($data[$key] ?? $default);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getStringOrNull(array $data, string $key): ?string
    {
        return isset($data[$key]) ? (string) $data[$key] : null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getIntOrNull(array $data, string $key): ?int
    {
        return isset($data[$key]) ? (int) $data[$key] : null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getFloatOrNull(array $data, string $key): ?float
    {
        return isset($data[$key]) ? (float) $data[$key] : null;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getBool(array $data, string $key, bool $default = false): bool
    {
        return (bool) ($data[$key] ?? $default);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getBoolOrNull(array $data, string $key): ?bool
    {
        return isset($data[$key]) ? (bool) $data[$key] : null;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<mixed>
     */
    protected static function getArray(array $data, string $key): array
    {
        return (array) ($data[$key] ?? []);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getCarbon(array $data, string $key): Carbon
    {
        return Carbon::parse(self::getString($data, $key));
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected static function getCarbonOrNull(array $data, string $key): ?Carbon
    {
        $value = $data[$key] ?? null;

        if ($value === null || $value === '' || $value === false) {
            return null;
        }

        return Carbon::parse($value);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return Collection<int, mixed>
     */
    protected static function getCollection(array $data, string $key): Collection
    {
        return collect($data[$key] ?? []);
    }
}
