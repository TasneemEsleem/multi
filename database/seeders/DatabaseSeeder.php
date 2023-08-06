<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'SuperAdmin',
        //     'email' => 'superadmin@example.com',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'role_type' => '0',
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'role_type' => '1',
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Data Entry',
        //     'email' => 'dataEntry@example.com',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'role_type' => '2',
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Financial',
        //     'email' => 'financial@example.com',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'role_type' => '3',
        // ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Customer',
        //     'email' => 'customer@example.com',
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'role_type' => '4',
        // ]);

        $allPermission = Permission::where('guard_name', 'user')->get();

        // Create the Super-Admin role
        $superAdminRole = Role::create([
            'name' => 'Super-Admin',
            'guard_name' => 'user'
        ]);

        // Give the Super-Admin role all permissions
        $superAdminRole->syncPermissions($allPermission);

        // Create a new user and assign the Super-Admin role
        User::create([
            'name' => 'Test',
            'email' => 'tasneem@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role_type' => 0,
        ])->assignRole($superAdminRole);


    }
}
