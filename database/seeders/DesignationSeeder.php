<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing designations to avoid duplicates
        if (Schema::hasTable('designations')) {
            DB::table('designations')->delete();
        }

        // Get department IDs
        $departments = DB::table('departments')->pluck('id', 'name');

        $designations = [
            // IT Department
            ['name' => 'Software Developer', 'department_id' => $departments['Information Technology'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Senior Software Developer', 'department_id' => $departments['Information Technology'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IT Manager', 'department_id' => $departments['Information Technology'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'System Administrator', 'department_id' => $departments['Information Technology'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'DevOps Engineer', 'department_id' => $departments['Information Technology'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            
            // HR Department
            ['name' => 'HR Manager', 'department_id' => $departments['Human Resources'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR Specialist', 'department_id' => $departments['Human Resources'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Recruiter', 'department_id' => $departments['Human Resources'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            
            // Finance Department
            ['name' => 'Finance Manager', 'department_id' => $departments['Finance'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accountant', 'department_id' => $departments['Finance'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Financial Analyst', 'department_id' => $departments['Finance'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            
            // Marketing Department
            ['name' => 'Marketing Manager', 'department_id' => $departments['Marketing'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Content Creator', 'department_id' => $departments['Marketing'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Social Media Manager', 'department_id' => $departments['Marketing'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            
            // Sales Department
            ['name' => 'Sales Manager', 'department_id' => $departments['Sales'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales Representative', 'department_id' => $departments['Sales'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Account Executive', 'department_id' => $departments['Sales'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            
            // Operations Department
            ['name' => 'Operations Manager', 'department_id' => $departments['Operations'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Operations Coordinator', 'department_id' => $departments['Operations'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            
            // Customer Support Department
            ['name' => 'Support Manager', 'department_id' => $departments['Customer Support'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Support Specialist', 'department_id' => $departments['Customer Support'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            
            // Administration Department
            ['name' => 'Office Manager', 'department_id' => $departments['Administration'] ?? null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Administrative Assistant', 'department_id' => $departments['Administration'] ?? null, 'created_at' => now(), 'updated_at' => now()],
        ];

        // Filter out any designations with null department_id
        $validDesignations = array_filter($designations, function ($designation) {
            return $designation['department_id'] !== null;
        });

        if (!empty($validDesignations)) {
            DB::table('designations')->insert($validDesignations);
        }
    }
}
