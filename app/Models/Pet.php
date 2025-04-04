<?php

namespace App\Models;

use App\Events\PetCreated;
use App\Events\PetDeleted;
use App\Events\PetUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pet extends Model
{
    /** @use HasFactory<\Database\Factories\PetFactory> */
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pet) {
            $pet->slug = Str::slug($pet->species . '-' . $pet->color . '-' . now()->timestamp . '-' . Str::random(5));
        });
    }

    public function adoptionApplication()
    {
        return $this->hasOne(AdoptionApplication::class);
    }

    protected static function booted()
    {
        static::created(function ($pet) {
            // Fire the PetCreated event when a pet is created
            event(new PetCreated($pet));
        });

        // Fire the PetUpdated event when a pet is updated
        static::updated(function ($pet) {
            event(new PetUpdated($pet));
        });

        // Fire the PetDeleted event when a pet is deleted
        static::deleted(function ($pet) {
            event(new PetDeleted($pet));
        });
    }
}
