<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * This is the main seeder file. It runs when you execute:
     * php artisan db:seed
     * or
     * php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        // Optionally create 10 fake users (commented out by default)
        // User::factory(10)->create();

        // Call additional seeders to populate permissions, roles, and a default user
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            DefaultUserSeeder::class,
        ]);

        // Optionally create 20 fake contacts (commented out by default)
        Contact::factory()->count(20)->create();
    }
}
