<?php

namespace App\Console\Commands;

use App\Schedule;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ScheduleRepeat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitterbot:repeat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repeat schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $settings = Setting::findOrNew(1);
        if (!$settings->bot_power || !$settings->schedule_power || !$settings->consumer_key || !$settings->consumer_secret || !$settings->access_token || !$settings->access_secret || !$settings->schedule_repeat) {
            return 1;
        }

        Schedule::orderBy('id')
            ->where('sent', 1)
            ->chunk(200, function ($items) {

            /** @var Schedule $schedule */
            foreach ($items as $schedule) {
                $schedule->sent = 0;
                $date           = Carbon::parse($schedule->date);
                $year           = (int)$date->year;
                $newDate        = $date->setYear($year + 1);
                $schedule->date = $newDate->format('Y-m-d');
                $schedule->save();
                $this->line('Done with #'.$schedule->id);
            }

        });

        $this->info('Finished');

        return 0;
    }
}
