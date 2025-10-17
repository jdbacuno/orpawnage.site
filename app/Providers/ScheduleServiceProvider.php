<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
  public function boot(Schedule $schedule): void
  {
    // updating featured pet task
    $schedule->command('app:update-featured-pets')
      ->everyMinute()
      //  ->onOneServer()
      ->appendOutputTo(storage_path('logs/update-featured-pets.log'));

    // adoption tasks
    $schedule->command('applications:reject-unconfirmed')
      ->everyMinute()
      // ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-reject.log'));

    $schedule->command('applications:reject-unscheduled')
      ->everyMinute()
      // ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-reject-unscheduled.log'));

    // Auto-lift temporary bans
    $schedule->command('users:auto-lift-temporary-bans')
      ->everyMinute() // Run daily to check for expired temporary bans
      // ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-lift-temporary-bans.log'));

    // surrender tasks
    $schedule->command('surrender:reject-unconfirmed')
      ->everyMinute()
      // ->onOneServer()
      ->appendOutputTo(storage_path('logs/surrender-auto-reject.log'));
  }
}
