<?php

namespace App\Events;

use App\Models\AdoptionApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdoptionStatusUpdated
{
    use Dispatchable, SerializesModels;

    public $application;

    public function __construct(AdoptionApplication $application)
    {
        $this->application = $application;
    }
}
