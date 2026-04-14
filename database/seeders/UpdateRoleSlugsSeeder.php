<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateRoleSlugsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = DB::table('roles')->get();
        
        foreach ($roles as $role) {
            if (empty($role->slug)) {
                DB::table('roles')
                    ->where('id', $role->id)
                    ->update(['slug' => Str::slug($role->name)]);
            }
        }
    }
}
