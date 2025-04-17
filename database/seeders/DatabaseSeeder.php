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
            'username' => 'orpawnage_team',
            'email' => 'orpawnageteam@gmail.com',
            'contact_number' => '09944318413',
            'password' => 'Admin25!',
            'email_verified_at' => now()
        ]);  // 1 admin

        // $this->call(PetSeeder::class);
    }
}
