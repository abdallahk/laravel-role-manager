<?php

namespace AbdallahK\LaravelRoleManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        $userModel = config('role-manager.models.user');
        
        $users = $userModel::with('roles')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(config('role-manager.ui.per_page', 15));

        return response()->json(compact('users'));
    }

    public function show($userId)
    {
        $userModel = config('role-manager.models.user');
        $user = $userModel::with('roles.permissions')->findOrFail($userId);
        $availableRoles = Role::all();

        return response()->json(compact('user', 'availableRoles'));
    }

    public function assignRoles(Request $request, $userId)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $userModel = config('role-manager.models.user');
        $user = $userModel::findOrFail($userId);
        
        $user->roles()->sync($request->roles ?? []);

        return response()->json([
            'message' => 'User roles updated successfully.',
            'user' => $user->load('roles')
        ]);
    }

    public function removeRole($userId, Role $role)
    {
        $userModel = config('role-manager.models.user');
        $user = $userModel::findOrFail($userId);
        
        $user->removeRole($role);

        return response()->json([
            'message' => 'Role removed from user successfully.',
            'user' => $user->load('roles')
        ]);
    }
}