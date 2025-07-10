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

            // ❗ Important: This is *not* a seeder class, it's a call to generate 20 fake contacts.
            // It uses the ContactFactory to insert 20 records into the "contacts" table.
            Contact::factory()->count(20)->create(),
            Contact::factory()->count(20)->create(), // Use the Contact Factory to create 20 users
        ]);
    }
}
