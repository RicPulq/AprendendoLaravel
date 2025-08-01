<?php

namespace App\Providers;

use App\Repository\EloquentSeriesRepository;
use App\Repository\SeriesRepository;
use Illuminate\Support\ServiceProvider;

class SeriesRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SeriesRepository::class, EloquentSeriesRepository::class,);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
