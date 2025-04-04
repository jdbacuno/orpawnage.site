<?php

namespace App\Events;

use App\Models\Pet;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PetCreated
{
    use Dispatchable, SerializesModels;

    public $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }
}
