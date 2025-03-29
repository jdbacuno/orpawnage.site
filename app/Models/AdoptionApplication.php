<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
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
}
