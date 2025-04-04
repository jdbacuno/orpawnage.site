<?php

namespace App\Listeners;

use App\Events\PetCreated;
use App\Events\PetDeleted;
use App\Events\PetUpdated;
use App\Events\AdoptionApplicationCreated;
use App\Events\AdoptionStatusUpdated;
use App\Events\AdoptionApplicationDeleted;
use Illuminate\Support\Facades\Artisan;

class UpdateFeaturedPetsListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Check if any of these events are triggered, and call the console command
        if (
            $event instanceof PetCreated ||
            $event instanceof PetDeleted ||
            $event instanceof PetUpdated ||
            $event instanceof AdoptionApplicationCreated ||
            $event instanceof AdoptionStatusUpdated ||
            $event instanceof AdoptionApplicationDeleted
        ) {
            // Call the console command to update featured pets
            Artisan::call('app:update-featured-pets');
        }
    }
}
