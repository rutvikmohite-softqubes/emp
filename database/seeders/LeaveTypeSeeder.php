<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Sick Leave', 'is_active' => true],
            ['name' => 'Casual Leave', 'is_active' => true],
            ['name' => 'Annual Leave', 'is_active' => true],
            ['name' => 'Maternity Leave', 'is_active' => true],
            ['name' => 'Paternity Leave', 'is_active' => true],
            ['name' => 'Emergency Leave', 'is_active' => true],
            ['name' => 'Study Leave', 'is_active' => true],
            ['name' => 'Unpaid Leave', 'is_active' => true],
            ['name' => 'Compensatory Off', 'is_active' => true],
            ['name' => 'Bereavement Leave', 'is_active' => true],
        ];

        foreach ($leaveTypes as $leaveType) {
            LeaveType::firstOrCreate(
                ['name' => $leaveType['name']],
                ['is_active' => $leaveType['is_active']]
            );
        }

        $this->command->info('Leave types seeded successfully!');
    }
}
