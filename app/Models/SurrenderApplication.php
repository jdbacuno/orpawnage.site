<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurrenderApplication extends Model
{
    protected $casts = [
        'pickup_date' => 'date:Y-m-d', // Ensures it's treated as a Carbon instance
        'birthdate' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
