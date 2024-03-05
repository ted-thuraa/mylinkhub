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
<<<<<<< HEAD
        $schedule->command('app:store-daily-analytics');
=======
        //$schedule->command('app:store-daily-analytics');
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
<<<<<<< HEAD
        $this->load(__DIR__.'/Commands/StoreDailyAnalytics.php');
=======
        //$this->load(__DIR__.'/Commands/StoreDailyAnalytics.php');
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02

        require base_path('routes/console.php');
    }
}