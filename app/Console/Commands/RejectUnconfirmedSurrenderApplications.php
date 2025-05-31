<?php

namespace App\Console\Commands;

use App\Models\SurrenderApplication;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RejectUnconfirmedSurrenderApplications extends Command
{
  protected $signature = 'surrender:reject-unconfirmed';
  protected $description = 'Reject surrender applications that were not confirmed within 24 hours';

  public function handle()
  {
    $cutoff = Carbon::now()->subMinute(); // subHours(24)

    $applications = SurrenderApplication::where('status', 'to be confirmed')
      ->where('created_at', '<=', $cutoff)
      ->get();

    foreach ($applications as $application) {
      $application->update([
        'status' => 'rejected',
        'reject_reason' => 'Application not confirmed within 24 hours'
      ]);

      $application->user->notify(new \App\Notifications\SurrenderStatusNotification($application));
    }

    $this->info("Rejected {$applications->count()} unconfirmed surrender applications.");
  }
}
