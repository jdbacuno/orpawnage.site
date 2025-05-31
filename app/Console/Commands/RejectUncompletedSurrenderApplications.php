<?php

namespace App\Console\Commands;

use App\Models\SurrenderApplication;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RejectUncompletedSurrenderApplications extends Command
{
  protected $signature = 'surrender:reject-uncompleted';
  protected $description = 'Reject surrender applications that were not completed within 3 business days of scheduled date';

  public function handle()
  {
    $cutoff = Carbon::now()->subMinute(); // subWeekdays(3)

    $applications = SurrenderApplication::where('status', 'surrender on-going')
      ->where('surrender_date', '<=', $cutoff)
      ->get();

    foreach ($applications as $application) {
      $application->update([
        'status' => 'rejected',
        'reject_reason' => 'Did not complete surrender within 3 business days of scheduled date'
      ]);

      $application->user->notify(new \App\Notifications\SurrenderStatusNotification($application));
    }

    $this->info("Rejected {$applications->count()} uncompleted surrender applications.");
  }
}
