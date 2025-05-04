<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
  public function boot(Schedule $schedule): void
  {
    $schedule->command('app:update-featured-pets')->everyMinute();

    $schedule->command('applications:reject-unconfirmed')
      ->everyMinute()
      ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-reject.log'));
  }
}
