<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->admin()->create([
            'username' => 'orpawnage_admin',
            'email' => 'unidentifiedhumanlifeform@gmail.com',
            'contact_number' => '09053461306',
            'password' => '123456',
            'email_verified_at' => now()
        ]);  // 1 admin

        // $this->call(PetSeeder::class);
    }
}
