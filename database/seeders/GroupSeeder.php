<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;
use App\Models\Permission;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create groups
        $admin = Group::firstOrCreate(['name' => 'Admin']);
        $editor = Group::firstOrCreate(['name' => 'Editor']);

        // Attach all permissions to Admin
        $admin->permissions()->syncWithoutDetaching(
            Permission::all()->pluck('id')->toArray()
        );

        // Attach limited permissions to Editor
        $editor->permissions()->syncWithoutDetaching(
            Permission::whereIn('name', ['view_users', 'create_users'])->pluck('id')->toArray()
        );
    }
}
