<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivedAdoptionApplication extends Model
{
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
