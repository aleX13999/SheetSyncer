<?php

namespace App\Providers;

use App\Application\Cache\CacheServiceInterface;
use App\Application\Note\Repository\NoteRepositoryInterface;
use App\Repositories\NoteRepository;
use App\Services\Cache\CacheService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NoteRepositoryInterface::class, NoteRepository::class);
        $this->app->bind(CacheServiceInterface::class, CacheService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
