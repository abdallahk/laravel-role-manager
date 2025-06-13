<?php

namespace AbdallahK\LaravelRoleManager\Helpers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagerHelper
{
    public static function getStats()
    {
        return [
            'roles_count' => Role::count(),
            'permissions_count' => Permission::count(),
            'users_count' => config('role-manager.models.user')::count(),
            'recent_roles' => Role::latest()->take(5)->get(),
        ];
    }

    public static function getPermissionsByCategory()
    {
        return Permission::all()->groupBy(function ($permission) {
            $parts = explode(' ', $permission->name);
            return $parts[0] ?? 'general';
        });
    }

    public static function createDefaultRolesAndPermissions()
    {
        // Create default permissions
        $permissions = [
            'manage roles',
            'manage permissions', 
            'assign roles',
            'view users',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create admin role with all permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        // Create basic user role
        Role::firstOrCreate(['name' => 'user']);
    }
}