<?php

namespace App\Console\Commands;

use App\Models\AdoptionApplication;
use App\Notifications\AdoptionStatusNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RejectUnconfirmedApplications extends Command
{
    protected $signature = 'applications:reject-unconfirmed';
    protected $description = 'Automatically reject unconfirmed adoption applications after 24 hours';

    public function handle()
    {
        $cutoff = Carbon::now()->subHours(24); // subMinute() to test

        $applications = AdoptionApplication::with('user')
            ->where('status', 'to be confirmed')
            ->where('created_at', '<=', $cutoff)
            ->get();

        foreach ($applications as $app) {
            $app->update([
                'status' => 'rejected',
                'reject_reason' => 'Application not confirmed within 24 hours'
            ]);

            $app->user->notify(new AdoptionStatusNotification($app->id));
        }

        $this->info("Auto-rejected {$applications->count()} applications");
        return 0;
    }
}
