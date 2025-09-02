<?php

namespace App\Application\Cache;

interface CacheServiceInterface
{
    public function create(string $key, string $value): bool;
    public function get(string $key): mixed;
}
