<?php

namespace App\Console\Commands;

use App\Models\Mainlinkanalytics;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class StoreDailyAnalytics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-daily-analytics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store daily analytics data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
<<<<<<< HEAD
        $date = now()->subDay()->toDateString();
        $users = User::all();

        foreach ($users as $user) {
            // Check if there is already an analytics record for the current date and user
            $existingAnalytics = Mainlinkanalytics::where('date', $date)
                ->where('user_id', $user->id)
                ->first();

            if (!$existingAnalytics) {
                // Create a new analytics record for the current date and user with zero values
                $analytics = new Mainlinkanalytics;
                $analytics->date = $date;
                $analytics->user_id = $user->id;
                $analytics->name = $user->name;
                $analytics->views = 0;
                $analytics->clicks = 0;
                $analytics->conversions = 0;
                $analytics->save();
            }
        }

        // Delete analytics data older than one month
        $oneMonthAgo = Carbon::now()->subMonth()->toDateString();
        Mainlinkanalytics::whereDate('date', '<', $oneMonthAgo)->delete();

        $this->info('Daily analytics data stored successfully.');
=======
        // $date = now()->subDay()->toDateString();
        // $users = User::all();

        // foreach ($users as $user) {
        //     // Check if there is already an analytics record for the current date and user
        //     $existingAnalytics = Mainlinkanalytics::where('date', $date)
        //         ->where('user_id', $user->id)
        //         ->first();

        //     if (!$existingAnalytics) {
        //         // Create a new analytics record for the current date and user with zero values
        //         $analytics = new Mainlinkanalytics;
        //         $analytics->date = $date;
        //         $analytics->user_id = $user->id;
        //         $analytics->name = $user->name;
        //         $analytics->views = 0;
        //         $analytics->clicks = 0;
        //         $analytics->conversions = 0;
        //         $analytics->save();
        //     }
        // }

        // // Delete analytics data older than one month
        // $oneMonthAgo = Carbon::now()->subMonth()->toDateString();
        // Mainlinkanalytics::whereDate('date', '<', $oneMonthAgo)->delete();

        // $this->info('Daily analytics data stored successfully.');
>>>>>>> c7b34354aa909a8d74f6e9ec7ce888db0cf51b02
    }
}