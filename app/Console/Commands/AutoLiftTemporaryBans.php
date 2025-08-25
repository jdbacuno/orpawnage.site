<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UserUnbannedNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoLiftTemporaryBans extends Command
{
    protected $signature = 'users:auto-lift-temporary-bans';
    protected $description = 'Automatically lift temporary bans that have expired';

    public function handle()
    {
        $now = Carbon::now();

        // Get users whose temporary ban has expired
        $users = User::where('is_temporarily_banned', true)
            ->where('temporary_ban_expires_at', '<=', $now)
            ->get();

        $count = 0;
        foreach ($users as $user) {
            $user->update([
                'is_temporarily_banned' => false,
                'temporary_ban_reason' => null,
                'temporarily_banned_at' => null,
                'temporary_ban_expires_at' => null
            ]);

            // Send notification that temporary ban has been lifted
            $user->notify(new UserUnbannedNotification($user));

            $this->info("Temporary ban lifted for user {$user->email}");
            $count++;
        }

        $this->info("Auto-lifted temporary bans for {$count} users");
        return 0;
    }
}
