<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Enums\UserRole;
use App\Enums\UserStatus;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users to avoid duplicates
        if (Schema::hasTable('users')) {
            DB::table('users')->delete();
        }

        // Get department and designation IDs
        $departments = DB::table('departments')->pluck('id', 'name');
        $designations = DB::table('designations')->pluck('id', 'name');

        $users = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@wowdash.com',
                'password' => Hash::make('password'),
                'department_id' => $departments['Information Technology'] ?? null,
                'designation_id' => $designations['IT Manager'] ?? null,
                'status' => UserStatus::Active->value,
                'role' => UserRole::Admin->value,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'John Developer',
                'email' => 'john@wowdash.com',
                'password' => Hash::make('password'),
                'department_id' => $departments['Information Technology'] ?? null,
                'designation_id' => $designations['Senior Software Developer'] ?? null,
                'status' => UserStatus::Active->value,
                'role' => UserRole::User->value,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Manager',
                'email' => 'jane@wowdash.com',
                'password' => Hash::make('password'),
                'department_id' => $departments['Human Resources'] ?? null,
                'designation_id' => $designations['HR Manager'] ?? null,
                'status' => UserStatus::Active->value,
                'role' => UserRole::User->value,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mike Sales',
                'email' => 'mike@wowdash.com',
                'password' => Hash::make('password'),
                'department_id' => $departments['Sales'] ?? null,
                'designation_id' => $designations['Sales Manager'] ?? null,
                'status' => UserStatus::Active->value,
                'role' => UserRole::User->value,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah Finance',
                'email' => 'sarah@wowdash.com',
                'password' => Hash::make('password'),
                'department_id' => $departments['Finance'] ?? null,
                'designation_id' => $designations['Finance Manager'] ?? null,
                'status' => UserStatus::Active->value,
                'role' => UserRole::User->value,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Filter out any users with null foreign keys
        $validUsers = array_filter($users, function ($user) {
            return $user['department_id'] !== null && $user['designation_id'] !== null;
        });

        if (!empty($validUsers)) {
            DB::table('users')->insert($validUsers);
        }
    }
}
