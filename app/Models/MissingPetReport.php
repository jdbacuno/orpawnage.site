<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissingPetReport extends Model
{
    use HasFactory;

    protected $casts = [
        'pickup_date' => 'date:Y-m-d', // Ensures it's treated as a Carbon instance
        'last_seen_date' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
