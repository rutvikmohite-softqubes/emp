<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'create-team-lead', 'description' => 'Create new team leads'],
            ['name' => 'edit-team-lead', 'description' => 'Edit existing team leads'],
            ['name' => 'delete-team-lead', 'description' => 'Delete team leads'],
            ['name' => 'view-team-leads', 'description' => 'View team lead list'],

            ['name' => 'create-employee', 'description' => 'Create new employees'],
            ['name' => 'edit-employee', 'description' => 'Edit existing employees'],
            ['name' => 'delete-employee', 'description' => 'Delete employees'],
            ['name' => 'view-employees', 'description' => 'View employee list'],

            ['name' => 'create-manager', 'description' => 'Create new managers'],
            ['name' => 'edit-manager', 'description' => 'Edit existing managers'],
            ['name' => 'delete-manager', 'description' => 'Delete managers'],
            ['name' => 'view-managers', 'description' => 'View manager list'],

            ['name' => 'create-director', 'description' => 'Create new directors'],
            ['name' => 'edit-director', 'description' => 'Edit existing directors'],
            ['name' => 'delete-director', 'description' => 'Delete directors'],
            ['name' => 'view-directors', 'description' => 'View director list'],

            ['name' => 'create-ceo', 'description' => 'Create new ceos'],
            ['name' => 'edit-ceo', 'description' => 'Edit existing ceos'],
            ['name' => 'delete-ceo', 'description' => 'Delete ceos'],
            ['name' => 'view-ceos', 'description' => 'View ceo list'],

            ['name' => 'create-task', 'description' => 'Create new tasks'],
            ['name' => 'edit-task', 'description' => 'Edit existing tasks'],
            ['name' => 'delete-task', 'description' => 'Delete tasks'],
            ['name' => 'view-tasks', 'description' => 'View task list'],

            ['name' => 'assign-task', 'description' => 'Assign tasks to users'],
            ['name' => 'edit-assign-task', 'description' => 'Edit assigned tasks'],
            ['name' => 'delete-assign-task', 'description' => 'Delete assigned tasks'],
            ['name' => 'view-assign-tasks', 'description' => 'View assigned tasks'],

            ['name' => 'approve-leave', 'description' => 'Approve leave requests'],
            ['name' => 'edit-approve-leave', 'description' => 'Edit approved leave requests'],
            ['name' => 'delete-approve-leave', 'description' => 'Delete approved leave requests'],
            ['name' => 'view-approve-leaves', 'description' => 'View approved leave requests'],

        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
