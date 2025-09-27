<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Support\Facades\Hash;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_inherits_permissions_from_group()
    {
        // Arrange: create group + permission
        $group = Group::create(['name' => 'TestGroup']);
        $permission = Permission::create(['name' => 'create_users']);
        $group->permissions()->attach($permission->id);

        // Create user and attach group
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'role' => 'manager'
        ]);

        $user->groups()->attach($group->id);

        // Act: get permissions through relationship
        $permissions = $user->permissions();

        // Assert: permissions collection contains the one we attached
        $this->assertTrue($permissions->contains('name', 'create_users'));
    }

    /** @test */
    public function user_has_permission_returns_true_for_inherited_permissions()
    {
        $group = Group::create(['name' => 'Admin']);
        $permission = Permission::create(['name' => 'delete_users']);
        $group->permissions()->attach($permission->id);

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'phone' => '1234567890',
            'role' => 'admin'
        ]);

        $user->groups()->attach($group->id);

        $this->assertTrue($user->hasPermission('delete_users'));
        $this->assertFalse($user->hasPermission('create_users')); // negative test
    }

    /** @test */
    public function user_with_no_groups_has_no_permissions()
    {
        $user = User::create([
            'name' => 'No Group User',
            'email' => 'nogroup@example.com',
            'password' => Hash::make('password'),
            'phone' => '1111111111',
            'role' => 'user'
        ]);

        $this->assertCount(0, $user->permissions());
        $this->assertFalse($user->hasPermission('view_users'));
    }
}
