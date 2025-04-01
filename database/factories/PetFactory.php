<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
    // public function definition(): array
    // {
    //     return [
    //         'pet_number' => fake()->numberBetween(1, 20),
    //         'species' => fake()->randomElement(['feline', 'canine']),
    //         'breed' => fake()->word(),
    //         'age' => fake()->numberBetween(1, 15),
    //         'age_unit' => fake()->randomElement(['months', 'years']),
    //         'sex' => fake()->randomElement(['male', 'female']),
    //         'color' => fake()->colorName(),
    //         'image_path' => 'pet-images/catdog.svg',
    //     ];
    // }

    public function definition()
    {
        $species = $this->faker->randomElement(['feline', 'canine']);

        // Generate a unique slug by appending uniqid()
        $slug = Str::slug("{$species}" . uniqid());

        return [
            'pet_number' => $this->faker->unique()->numberBetween(1, 1000),
            'species' => $species,
            'name' => $this->faker->firstName(),
            'age' => $this->faker->numberBetween(1, 15),
            'age_unit' => $this->faker->randomElement(['months', 'years']),
            'sex' => $this->faker->randomElement(['male', 'female']),
            'reproductive_status' => $this->faker->randomElement(['intact', 'neutered', 'unknown']),
            'color' => $this->faker->randomElement(['black', 'white', 'orange', 'brown']),
            'source' => $this->faker->randomElement(['surrendered', 'rescued', 'other']),
            'image_path' => 'pet-images/catdog.svg',
            'slug' => $slug, // Ensures uniqueness
        ];
    }
}
