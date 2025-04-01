<?php

namespace App\Models;

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
}
