<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'male',
                'role_id' => 1, // Assuming Super Admin has ID 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'female',
                'role_id' => 2, // Assuming HR has ID 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'male',
                'role_id' => 3, // Assuming Employee has ID 3
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'female',
                'role_id' => 3, // Employee
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'robert.wilson@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'male',
                'role_id' => 3, // Employee
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jessica Martinez',
                'email' => 'jessica.martinez@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'female',
                'role_id' => 2, // HR
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Lee',
                'email' => 'david.lee@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'male',
                'role_id' => 3, // Employee
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alex Taylor',
                'email' => 'alex.taylor@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'other',
                'role_id' => 3, // Employee
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'female',
                'role_id' => 2, // HR
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'James Anderson',
                'email' => 'james.anderson@example.com',
                'password' => Hash::make('password123'),
                'gender' => 'male',
                'role_id' => 3, // Employee
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
