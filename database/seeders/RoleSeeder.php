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
        $contactmanager = Role::create(['name' => 'Contact Manager']);
        $user = Role::create(['name' => 'User']);

        $admin->givePermissionTo([
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'deactivate-user',
            'view-contact',
            'create-contact',
            'edit-contact',
            'deactivate-contact',
            'restore-contact',
            'excel-contact'
        ]);


        $contactmanager->givePermissionTo([
            'view-contact',
            'create-contact',
            'edit-contact',
            'deactivate-contact'
        ]);


        $user->givePermissionTo([
            'view-contact'
        ]);
    }
}
