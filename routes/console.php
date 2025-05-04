<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
  protected function schedule(Schedule $schedule): void
  {
    $schedule->command('app:update-featured-pets')->everyMinute(); // For testing

    $schedule->command('applications:reject-unconfirmed')
      ->everyMinute()
      ->onOneServer()
      ->appendOutputTo(storage_path('logs/auto-reject.log'));
  }

  protected function commands(): void
  {
    $this->load(__DIR__ . '/Commands');
  }
}
