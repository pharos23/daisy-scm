<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

// Seeder for roles and permissions. Here we create the roles and assign the permissions to each role. THIS IS THE FILE WE ARE USING.
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);

        $admin->givePermissionTo([
            'create-user',
            'edit-user',
            'delete-user',
            'view-contact',
            'create-contact',
            'edit-contact',
            'delete-contact'
        ]);

        $user->givePermissionTo([
            'view-contact'
        ]);
    }
}
