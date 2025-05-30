<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
  public function boot(Schedule $schedule): void
  {
    $schedule->command('app:update-featured-pets')
      ->everyMinute()
      ->onOneServer()
      ->appendOutputTo(storage_path('logs/update-featured-pets.log'));

    $schedule->command('applications:reject-unconfirmed')
      ->everyMinute()
      ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-reject.log'));

    $schedule->command('applications:reject-unscheduled')
      ->everyMinute()
      ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-reject-unscheduled.log'));

    $schedule->command('applications:reject-unpicked')
      ->daily()
      ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-reject-unpicked.log'));

    $schedule->command('users:auto-ban-rejected-applications')
      ->daily() // Run daily to check for violations
      ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-ban-users.log'));
  }
}
