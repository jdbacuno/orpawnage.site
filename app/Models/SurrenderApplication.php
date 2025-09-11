<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurrenderApplication extends Model
{
    protected $casts = [
        'pickup_date' => 'date:Y-m-d', // Ensures it's treated as a Carbon instance
        'surrender_date' => 'date:Y-m-d',
        'birthdate' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
