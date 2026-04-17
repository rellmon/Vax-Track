<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class QueueAutoProcessProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Queue auto-processing provider
        // On Railway, you can run queued jobs with:
        //   php artisan queue:work database --once
        // Or setup a scheduled cron job to run this command every 5 minutes:
        //   */5 * * * * cd /app && php artisan queue:work database --max-jobs=10 --max-time=60
    }
}
