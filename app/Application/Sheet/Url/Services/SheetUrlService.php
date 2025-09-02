<?php

namespace App\Application\Sheet\Url\Services;

use App\Application\Cache\CacheServiceInterface;

readonly class SheetUrlService
{
    public function __construct(
        private CacheServiceInterface $cacheService,
    ) {}

    public function get(): mixed
    {
        return $this->cacheService->get('google_sheet_url');
    }

    /**
     * @throws \Exception
     */
    public function create(string $url): void
    {
        if (!$this->cacheService->create('google_sheet_url', $url)) {
            throw new \Exception('Failed to create Google Sheet url');
        }
    }
}
