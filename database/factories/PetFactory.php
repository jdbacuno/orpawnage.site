<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pet_number' => fake()->numberBetween(1, 20),
            'species' => fake()->randomElement(['feline', 'canine']),
            'breed' => fake()->word(),
            'age' => fake()->numberBetween(1, 15),
            'age_unit' => fake()->randomElement(['months', 'years']),
            'sex' => fake()->randomElement(['male', 'female']),
            'color' => fake()->colorName(),
            'image_path' => 'images/default.jpg',
        ];
    }
}
