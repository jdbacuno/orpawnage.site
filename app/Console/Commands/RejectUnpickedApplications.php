<?php

namespace App\Console\Commands;

use App\Models\AdoptionApplication;
use App\Notifications\AdoptionStatusNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RejectUnpickedApplications extends Command
{
  protected $signature = 'applications:reject-unpicked';
  protected $description = 'Automatically reject adoption applications that were not picked up within 3 business days';

  public function handle()
  {
    // Get applications with status 'adoption on-going' where pickup_date is older than 3 business days
    $cutoffDate = Carbon::now()->subWeekdays(3); // subMinute() to test

    $applications = AdoptionApplication::with(['user', 'pet'])
      ->where('status', 'adoption on-going')
      ->whereDate('pickup_date', '<=', $cutoffDate)
      ->get();

    foreach ($applications as $app) {
      $formattedPickupDate = $app->pickup_date->format('F j, Y');

      $app->update([
        'status' => 'rejected',
        'reject_reason' => "Application not picked up within 3 business days from scheduled date (**{$formattedPickupDate}**)"
      ]);

      $app->user->notify(new AdoptionStatusNotification($app));
    }

    $this->info("Auto-rejected {$applications->count()} unpicked applications");
    return 0;
  }
}
