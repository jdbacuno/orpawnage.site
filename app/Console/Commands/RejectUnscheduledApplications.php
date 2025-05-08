<?php

namespace App\Console\Commands;

use App\Models\AdoptionApplication;
use App\Notifications\AdoptionStatusNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RejectUnscheduledApplications extends Command
{
  protected $signature = 'applications:reject-unscheduled';
  protected $description = 'Automatically reject adoption applications that were not scheduled within 48 hours';

  public function handle()
  {
    $cutoff = Carbon::now()->subMinutes(30);

    $applications = AdoptionApplication::with('user')
      ->where('status', 'to be scheduled')
      ->where('updated_at', '<=', $cutoff)
      ->get();

    foreach ($applications as $app) {
      $app->update([
        'status' => 'rejected',
        'reject_reason' => 'Pickup schedule not set within 48 hours'
      ]);

      $app->user->notify(new AdoptionStatusNotification($app));
    }

    $this->info("Auto-rejected {$applications->count()} unscheduled applications");
    return 0;
  }
}
