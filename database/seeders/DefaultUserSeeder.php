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
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'password' => Hash::make('SuperAdmin123'),
        ]);
        $superAdmin->assignRole('Super Admin');


        // Creating Admin User
        $admin = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => Hash::make('Admin123')
        ]);
        $admin->assignRole('Admin');


        // Creating Contact Manager User
        $user = User::create([
            'name' => 'Contact Manager',
            'username' => 'contactmanager',
            'password' => Hash::make('ContactManager123')
        ]);
        $user->assignRole('Contact Manager');


        // Creating View User
        $user = User::create([
            'name' => 'User',
            'username' => 'user',
            'password' => Hash::make('User123')
        ]);
        $user->assignRole('User');
    }
}
