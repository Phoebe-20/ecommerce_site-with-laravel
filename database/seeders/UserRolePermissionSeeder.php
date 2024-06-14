<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Create Permissions
       Permission::create(['name' => 'view role']);
       Permission::create(['name' => 'create role']);
       Permission::create(['name' => 'update role']);
       Permission::create(['name' => 'delete role']);

       Permission::create(['name' => 'view permission']);
       Permission::create(['name' => 'create permission']);
       Permission::create(['name' => 'update permission']);
       Permission::create(['name' => 'delete permission']);

       Permission::create(['name' => 'view user']);
       Permission::create(['name' => 'create user']);
       Permission::create(['name' => 'update user']);
       Permission::create(['name' => 'delete user']);


       // Create Roles
       $AdminRole = Role::create(['name' => 'Admin']); //as super-admin
       $CommercialRole = Role::create(['name' => 'Commercial']);
      

       // Lets give all permission to Admin role.
       $allPermissionNames = Permission::pluck('name')->toArray();

       $AdminRole->givePermissionTo($allPermissionNames);

       // Let's give few permissions to Commercial role.
       $CommercialRole->givePermissionTo(['view role']);
       $CommercialRole->givePermissionTo(['view permission']);
       $CommercialRole->givePermissionTo(['view user']);


       // Let's Create User and assign Role to it.
       $AdminUser = User::firstOrCreate([
                   'email' => 'admin@gmail.com',
               ], [
                   'name' => 'John',
                   'email' => 'admin@gmail.com',
                   'password' => Hash::make ('12345678'),
               ]);

       $AdminUser->assignRole($AdminRole);


       $CommercialUser = User::firstOrCreate([
                           'email' => 'commercal@gmail.com'
                       ], [
                           'name' => 'Amie',
                           'email' => 'commercial@gmail.com',
                           'password' => Hash::make ('87654321'),
                       ]);

       $CommercialUser->assignRole($CommercialRole);

    }
}
