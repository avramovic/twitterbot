<?php

namespace App\Console\Commands;

use App\Schedule;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MoveToNextYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitterbot:movetonextyear {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repeat schedule';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $year     = $this->argument('year') ?? date('Y');
        $settings = Setting::findOrNew(1);
        if (!$settings->bot_power || !$settings->schedule_power || !$settings->consumer_key || !$settings->consumer_secret || !$settings->access_token || !$settings->access_secret || !$settings->schedule_repeat) {
            return 1;
        }

        Schedule::orderBy('id')
            ->whereRaw('YEAR(date) < '.$year)
            ->chunk(200, function ($items) use ($year) {

                /** @var Schedule $schedule */
                foreach ($items as $schedule) {
                    $schedule->sent = 0;
                    $date           = Carbon::parse($schedule->date);
                    $newDate        = $date->setYear($year);
                    $schedule->date = $newDate->format('Y-m-d');
                    $schedule->save();
                    $this->line('Done with #'.$schedule->id);
                }

            });

        $this->info('Finished');

        return 0;
    }
}
