<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedPet extends Model
{
    protected $fillable = ['pet_id', 'adoption_probability'];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
