<?php

namespace App\Console;

use App\Console\Commands\Archive;
use App\Console\Commands\ChatCommand;
use App\Console\Commands\DMFollower;
use App\Console\Commands\MoveToNextYear;
use App\Console\Commands\Scheduled;
use App\Console\Commands\ScheduleRepeat;
use App\Console\Commands\UserInfo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Archive::class,
        ChatCommand::class,
        Scheduled::class,
        DMFollower::class,
        UserInfo::class,
        ScheduleRepeat::class,
        MoveToNextYear::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if (App::environment('production')) {
            $schedule->command('twitterbot:userinfo')
                ->everyMinute();

            $schedule->command('twitterbot:chat')
                ->everyMinute();

            $schedule->command('twitterbot:archive')
                ->everyMinute();

            $schedule->command('twitterbot:scheduled')
                ->everyMinute();

            $schedule->command('twitterbot:dmfollower')
                ->everyMinute();

            $schedule->command('twitterbot:repeat')
                ->yearly();

            $schedule->command('twitterbot:movetonextyear')
                ->monthlyOn(1, '01:00');
        }
    }

    /**
     * Register the Closure based commands for the appli   cation.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
