<?php

namespace App\Providers;

use App\Events\PetCreated;
use App\Events\PetUpdated;
use App\Events\PetDeleted;
use App\Events\AdoptionApplicationCreated;
use App\Events\AdoptionStatusUpdated;
use App\Events\AdoptionApplicationDeleted;
use App\Listeners\UpdateFeaturedPetsListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PetCreated::class => [
            UpdateFeaturedPetsListener::class,
        ],
        PetUpdated::class => [
            UpdateFeaturedPetsListener::class,
        ],
        PetDeleted::class => [
            UpdateFeaturedPetsListener::class,
        ],
        AdoptionApplicationCreated::class => [
            UpdateFeaturedPetsListener::class,
        ],
        AdoptionStatusUpdated::class => [
            UpdateFeaturedPetsListener::class,
        ],
        AdoptionApplicationDeleted::class => [
            UpdateFeaturedPetsListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
