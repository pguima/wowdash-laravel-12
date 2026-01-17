<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing departments to avoid duplicates
        if (Schema::hasTable('departments')) {
            DB::table('departments')->delete();
        }

        $departments = [
            ['name' => 'Information Technology', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Human Resources', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Marketing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Operations', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Customer Support', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administration', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('departments')->insert($departments);
    }
}
