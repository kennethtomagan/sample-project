<?php

namespace App\Providers;

use App\Repositories\BaseRepository;
use App\Repositories\BaseRepositoryInterface;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
