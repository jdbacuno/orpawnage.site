<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Pet;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdoptionApplication>
 */
class AdoptionApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // assumes you have a User factory
            'pet_id' => Pet::factory(),   // generates a new pet automatically
            'full_name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'age' => $this->faker->numberBetween(18, 65),
            'birthdate' => $this->faker->date(),
            'contact_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'civil_status' => $this->faker->randomElement(['single', 'married', 'widowed']),
            'citizenship' => $this->faker->country(),
            'reason_for_adoption' => $this->faker->sentence(10),
            'visit_veterinarian' => $this->faker->randomElement(['Yes', 'No', 'Sometimes']),
            'existing_pets' => $this->faker->numberBetween(0, 3),
            'valid_id' => 'sample-valid-id.jpg',
            'status' => 'picked up', // ✅ ensure these are marked as successful adoptions
            'previous_status' => null,
            'transaction_number' => strtoupper(Str::random(10)),
            'reject_reason' => null,
            'pickup_date' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
