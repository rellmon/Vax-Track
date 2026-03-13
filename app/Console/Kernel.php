<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send appointment reminders daily at 8:00 AM
        $schedule->command('reminders:send --hours=24')
            ->dailyAt('08:00')
            ->description('Send appointment reminder emails 24 hours before appointment');

        // Alternative: Send reminders every hour (for testing)
        // $schedule->command('reminders:send --hours=24')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
