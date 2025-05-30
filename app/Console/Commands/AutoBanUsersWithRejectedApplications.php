<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\AdoptionApplication;
use App\Notifications\UserBannedNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoBanUsersWithRejectedApplications extends Command
{
  protected $signature = 'users:auto-ban-rejected-applications';
  protected $description = 'Automatically ban users with 3 consecutive rejected adoption applications within one month';

  public function handle()
  {
    $oneMonthAgo = Carbon::now()->subMonth();

    // Get users who have at least 3 rejected applications in the last month
    $users = User::whereHas('adoptionApplications', function ($query) use ($oneMonthAgo) {
      $query->where('status', 'rejected')
        ->where('created_at', '>=', $oneMonthAgo);
    }, '>=', 3)
      ->where('is_banned', false)
      ->get();

    foreach ($users as $user) {
      // Check if the last 3 applications were consecutive rejections
      $lastThreeApplications = $user->adoptionApplications()
        ->orderBy('created_at', 'desc')
        ->limit(3)
        ->get();

      if (
        $lastThreeApplications->count() === 3 &&
        $lastThreeApplications->every(fn($app) => $app->status === 'rejected')
      ) {

        $banReason = 'Automatically banned due to 3 consecutive rejected adoption applications within one month';

        $user->update([
          'is_banned' => true,
          'ban_reason' => $banReason,
          'banned_at' => now()
        ]);

        $user->notify(new UserBannedNotification($user));

        $this->info("Banned user {$user->email} for 3 consecutive rejected applications");
      }
    }

    $this->info("Auto-banned {$users->count()} users");
    return 0;
  }
}
