<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Events\EndExecution;
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
        app('events')->listen(
            EndExecution::class,
            function ($event) {
                // Add cache flag to GraphQL response extensions
                $event->result->extensions['cache'] = $GLOBALS['cache_status'] ?? 'unknown';
            }
        );
    }
}
