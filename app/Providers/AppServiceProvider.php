<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Categories\Interfaces\CategoryRepositoryInterface;
use Modules\Categories\Repositories\CategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            \Modules\Categories\Interfaces\CategoryServiceInterface::class,
            \Modules\Categories\Services\CategoryService::class
        );
    }
}
