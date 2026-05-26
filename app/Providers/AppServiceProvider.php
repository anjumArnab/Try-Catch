<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        RateLimiter::for('logs', function (Request $request) {
            $project = $request->attributes->get('project');

            return Limit::perMinute((int) env('LOG_INGEST_RATE_LIMIT', 60))
                ->by($project?->id ?? $request->ip());
        });
    }
}
