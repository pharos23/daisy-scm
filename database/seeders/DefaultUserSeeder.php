<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// Seed the database with default users. We are adding users to the DB manually.
class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        $superAdmin = User::create([
            'name' => 'SuperAdmin',
            'email' => 'super@local.lan',
            'password' => Hash::make('SuperAdmin123'),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@local.lan',
            'password' => Hash::make('Admin123')
        ]);
        $admin->assignRole('Admin');

        // Creating Contact Manager User
        $productManager = User::create([
            'name' => 'ContactManager',
            'email' => 'contact@local.lan',
            'password' => Hash::make('ContactManager123')
        ]);
        $productManager->assignRole('Contact Manager');

        // Creating Application User
        $user = User::create([
            'name' => 'NormalUser',
            'email' => 'user@local.lan',
            'password' => Hash::make('NormalUser123')
        ]);
        $user->assignRole('User');
    }
}
