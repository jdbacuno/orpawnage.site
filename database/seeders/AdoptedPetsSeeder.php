<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdoptionApplication;

class AdoptedPetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 adopted pets with adoption records from the last 6 months
        AdoptionApplication::factory()->count(120)->create();

        $this->command->info('✅ Seeded 20 adopted pets with recent "picked up" adoptions.');
    }
}
