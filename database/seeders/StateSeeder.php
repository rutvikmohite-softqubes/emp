<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['name' => 'California', 'code' => 'CA'],
            ['name' => 'Texas', 'code' => 'TX'],
            ['name' => 'Florida', 'code' => 'FL'],
            ['name' => 'New York', 'code' => 'NY'],
            ['name' => 'Illinois', 'code' => 'IL'],
            ['name' => 'Pennsylvania', 'code' => 'PA'],
            ['name' => 'Ohio', 'code' => 'OH'],
            ['name' => 'Georgia', 'code' => 'GA'],
            ['name' => 'North Carolina', 'code' => 'NC'],
            ['name' => 'Michigan', 'code' => 'MI'],
            ['name' => 'New Jersey', 'code' => 'NJ'],
            ['name' => 'Virginia', 'code' => 'VA'],
            ['name' => 'Washington', 'code' => 'WA'],
            ['name' => 'Arizona', 'code' => 'AZ'],
            ['name' => 'Massachusetts', 'code' => 'MA'],
        ];

        foreach ($states as $state) {
            DB::table('states')->insert(array_merge($state, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
