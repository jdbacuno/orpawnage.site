<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\AdoptionApplicationCreated;
use App\Events\AdoptionApplicationDeleted;
use App\Events\AdoptionStatusUpdated;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{ 
    use HasFactory;
	
    protected $casts = [
        'pickup_date' => 'date:Y-m-d', // Ensures it's treated as a Carbon instance
        'birthdate' => 'date:Y-m-d',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($application) {
            if ($application->isDirty('status')) {
                $application->updated_at = now();
            }
        });
    }

    protected static function booted()
    {
        // Trigger the event when a new adoption application is created
        static::created(function ($adoptionApplication) {
            event(new AdoptionApplicationCreated($adoptionApplication));
        });

        // Fire the AdoptionStatusUpdated event when a status is updated
        static::updated(function ($adoptionApplication) {
            if ($adoptionApplication->isDirty('status')) {
                event(new AdoptionStatusUpdated($adoptionApplication));
            }
        });

        // Fire the AdoptionApplicationDeleted event when an adoption application is deleted
        static::deleted(function ($application) {
            event(new AdoptionApplicationDeleted($application));
        });
    }
}
