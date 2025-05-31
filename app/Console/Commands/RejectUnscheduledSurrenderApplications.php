<?php

namespace App\Console\Commands;

use App\Models\SurrenderApplication;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RejectUnscheduledSurrenderApplications extends Command
{
  protected $signature = 'surrender:reject-unscheduled';
  protected $description = 'Reject surrender applications that were not scheduled within 48 hours of confirmation';

  public function handle()
  {
    $cutoff = Carbon::now()->subHours(48);

    $applications = SurrenderApplication::where('status', 'to be scheduled')
      ->where('confirmed_at', '<=', $cutoff)
      ->get();

    foreach ($applications as $application) {
      $application->update([
        'status' => 'rejected',
        'reject_reason' => 'Did not schedule surrender within 48 hours of confirmation'
      ]);

      $application->user->notify(new \App\Notifications\SurrenderStatusNotification($application));
    }

    $this->info("Rejected {$applications->count()} unscheduled surrender applications.");
  }
}
