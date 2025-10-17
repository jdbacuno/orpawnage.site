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
            'pet_number' => $this->faker->unique()->numberBetween(1, 40),

            // First, decide species and store it for later use
            'species' => $species = $this->faker->randomElement(['feline', 'canine']),

            'pet_name' => '',

            // Decide whether to use "months" or "years"
            'age_unit' => $ageUnit = $this->faker->randomElement(['months', 'years']),

            // Age depends on the chosen age unit
            'age' => $ageUnit === 'years'
                ? $this->faker->numberBetween(1, 3)  // 1 to 3 years
                : $this->faker->numberBetween(1, 12), // 1 to 12 months

            'sex' => $this->faker->randomElement(['male', 'female']),
            'reproductive_status' => $this->faker->randomElement(['intact', 'neutered', 'unknown']),
            'color' => $this->faker->randomElement([
                'black',
                'white',
                'orange',
                'brown',
                'bi-color',
                'tri-color',
                'brindle',
                'other'
            ]),
            'source' => $this->faker->randomElement(['surrendered', 'rescued', 'other']),

            // Image depends on species
            'image_path' => $species === 'feline'
                ? $this->faker->imageUrl(360, 360, 'cats', true, 'cats', true, 'jpg')
                : $this->faker->imageUrl(360, 360, 'dogs', true, 'dogs', true, 'jpg'),

            'slug' => $slug, // Ensure uniqueness
        ];
    }
}
