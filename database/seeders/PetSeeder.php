<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pet;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Common pet names
        $dogNames = ['Buddy', 'Max', 'Charlie', 'Rocky', 'Bella', 'Lucy', 'Daisy', 'Molly', 'Sadie', 'Lola', 'Bruno', 'Zeus', 'Duke', 'Bear', 'Oscar', 'Milo', 'Rex', 'Jake', 'Jack', 'Toby'];
        $catNames = ['Whiskers', 'Shadow', 'Luna', 'Oliver', 'Milo', 'Leo', 'Simba', 'Tiger', 'Smokey', 'Oreo', 'Princess', 'Angel', 'Chloe', 'Nala', 'Coco', 'Bella', 'Mittens', 'Patches', 'Felix', 'Garfield'];
        
        // Common colors
        $dogColors = ['Brown', 'Black', 'White', 'Golden', 'Mixed Brown and White', 'Black and White', 'Tan', 'Gray', 'Chocolate', 'Cream'];
        $catColors = ['Orange', 'Black', 'White', 'Gray', 'Tabby', 'Calico', 'Tuxedo', 'Siamese', 'Brown', 'Silver'];
        
        // Fixed date for all records
        $fixedDate = Carbon::create(2025, 2, 1);
        
        for ($i = 1; $i <= 100; $i++) {
            $species = $faker->randomElement(['feline', 'canine']);
            
            // Get actual image URL
            if ($species === 'canine') {
                // Dog API returns JSON with image URL
                $response = Http::get('https://dog.ceo/api/breeds/image/random');
                $imageUrl = $response->json()['message'] ?? null;
            } else {
                // Cat API returns the actual image, so we use the direct URL
                $imageUrl = 'https://cataas.com/cat?width=400&height=400&' . $faker->uuid;
            }
            
            $petName = $species === 'canine' ? $faker->randomElement($dogNames) : $faker->randomElement($catNames);
            $color = $species === 'canine' ? $faker->randomElement($dogColors) : $faker->randomElement($catColors);
            
            // Generate age
            $ageUnit = $faker->randomElement(['months', 'years', 'weeks']);
            switch ($ageUnit) {
                case 'weeks':
                    $age = $faker->numberBetween(6, 16);
                    break;
                case 'months':
                    $age = $faker->numberBetween(2, 18);
                    break;
                case 'years':
                    $age = $faker->numberBetween(1, 12);
                    break;
                default:
                    $age = $faker->numberBetween(1, 5);
            }
            
            Pet::create([
                'slug' => Str::slug($petName . '-' . $i),
                'pet_number' => 2025000 + $i,
                'pet_name' => $petName,
                'species' => $species,
                'age' => $age,
                'age_unit' => $ageUnit,
                'sex' => $faker->randomElement(['male', 'female']),
                'reproductive_status' => $faker->randomElement(['intact', 'neutered', 'unknown']),
                'color' => $color,
                'source' => $faker->randomElement(['surrendered', 'rescued', 'other']),
                'image_path' => $imageUrl,
                'archive_reason' => null,
                'archive_notes' => null,
                'archived_at' => null,
                'created_at' => $fixedDate,
                'updated_at' => $fixedDate,
            ]);
            
            // Add a small delay to avoid hitting API rate limits
            usleep(100000); // 0.1 second delay
        }
    }
}
