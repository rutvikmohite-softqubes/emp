<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            // California cities
            ['name' => 'Los Angeles', 'state_code' => 'CA'],
            ['name' => 'San Francisco', 'state_code' => 'CA'],
            ['name' => 'San Diego', 'state_code' => 'CA'],
            ['name' => 'Sacramento', 'state_code' => 'CA'],
            
            // Texas cities
            ['name' => 'Houston', 'state_code' => 'TX'],
            ['name' => 'Austin', 'state_code' => 'TX'],
            ['name' => 'Dallas', 'state_code' => 'TX'],
            ['name' => 'San Antonio', 'state_code' => 'TX'],
            
            // Florida cities
            ['name' => 'Miami', 'state_code' => 'FL'],
            ['name' => 'Orlando', 'state_code' => 'FL'],
            ['name' => 'Tampa', 'state_code' => 'FL'],
            ['name' => 'Jacksonville', 'state_code' => 'FL'],
            
            // New York cities
            ['name' => 'New York City', 'state_code' => 'NY'],
            ['name' => 'Buffalo', 'state_code' => 'NY'],
            ['name' => 'Rochester', 'state_code' => 'NY'],
            ['name' => 'Albany', 'state_code' => 'NY'],
            
            // Illinois cities
            ['name' => 'Chicago', 'state_code' => 'IL'],
            ['name' => 'Springfield', 'state_code' => 'IL'],
            ['name' => 'Peoria', 'state_code' => 'IL'],
            
            // Other major cities
            ['name' => 'Philadelphia', 'state_code' => 'PA'],
            ['name' => 'Phoenix', 'state_code' => 'AZ'],
            ['name' => 'Seattle', 'state_code' => 'WA'],
            ['name' => 'Boston', 'state_code' => 'MA'],
            ['name' => 'Atlanta', 'state_code' => 'GA'],
            ['name' => 'Detroit', 'state_code' => 'MI'],
        ];

        foreach ($cities as $city) {
            $state = DB::table('states')->where('code', $city['state_code'])->first();
            
            if ($state) {
                DB::table('cities')->insert([
                    'name' => $city['name'],
                    'state_id' => $state->id,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
