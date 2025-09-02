<?php

namespace App\Services\Cache;

use App\Application\Cache\CacheServiceInterface;
use Illuminate\Support\Facades\Cache;

readonly class CacheService implements CacheServiceInterface
{
    public function create(string $key, string $value): bool
    {
        return Cache::forever($key, $value);
    }

    public function get(string $key): mixed
    {
        return Cache::get($key);
    }
}
