<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalAbuseReport extends Model
{
    protected $casts = [
        'pickup_date' => 'date:Y-m-d', // Ensures it's treated as a Carbon instance
        'incident_date' => 'date:Y-m-d'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
