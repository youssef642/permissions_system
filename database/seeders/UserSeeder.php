<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
public function run(): void
{
$adminGroup = Group::where('name', 'Admin')->first();
$editorGroup = Group::where('name', 'Editor')->first();

$adminUser = User::firstOrCreate(
['email' => 'admin@example.com'],
['name' => 'Admin User',
 'password' => Hash::make('password'),
 'phone' => '1234567890',
 'role' => 'admin']
);

$managerUser = User::firstOrCreate(
['email' => 'manager@example.com'],
[
 'name' => 'Manager User',
 'password' => Hash::make('password'),
 'phone' => '0987654321',
 'role' => 'manager'
 ]
);

// Attach users to groups (pivot table is users_groups)
$adminUser->groups()->syncWithoutDetaching([$adminGroup->id]);
$managerUser->groups()->syncWithoutDetaching([$editorGroup->id]);
}
}