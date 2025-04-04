<?php

namespace App\Events;

use App\Models\AdoptionApplication;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdoptionApplicationCreated
{
    use Dispatchable, SerializesModels;

    public $adoptionApplication;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\AdoptionApplication  $adoptionApplication
     * @return void
     */
    public function __construct(AdoptionApplication $adoptionApplication)
    {
        $this->adoptionApplication = $adoptionApplication;
    }
}
