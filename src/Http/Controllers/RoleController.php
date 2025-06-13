<?php

namespace AbdallahK\LaravelRoleManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::with('permissions')->withCount('users')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(config('role-manager.ui.per_page', 15));

        return response()->json(compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all() ?? null;
        return response()->json(compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }

        return response()->json([
            'message' => 'Role created successfully.',
            'role' => $role->load('permissions')
        ], 201);
    }

    public function show(Role $role)
    {
        // Load only permissions for the role details
        $role->load('permissions');
        return response()->json(compact('role'));
    }

    /**
     * Get paginated users for a specific role
     * 
     * @param Role $role
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRoleUsers(Role $role, Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('per_page', 15);

        $query = $role->users();

        // Apply search filter if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Order by name for consistent results
        $query->orderBy('name');

        // Paginate the results
        $users = $query->paginate($perPage);

        return response()->json(compact('users'));
    }

    // Alternative: If you want to add this to your existing routes, you can add this route:
    // Route::get('/roles/{role}/users', [RoleController::class, 'getRoleUsers']);

    // Or if you prefer to keep it in the show method and handle both cases:
    public function showAlternative(Role $role, Request $request)
    {
        // If requesting users specifically
        if ($request->has('users_only')) {
            return $this->getRoleUsers($role, $request);
        }

        // Otherwise return role details with permissions
        $role->load('permissions');
        return response()->json(compact('role'));
    }

    public function edit(Role $role)
    {
        $role->load('permissions');
        $permissions = Permission::all();

        // Return the exact structure your frontend expects
        return response()->json([
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return response()->json([
            'message' => 'Role updated successfully.',
            'role' => $role->load('permissions')
        ]);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully.']);
    }

    public function updatePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($request->permissions ?? []);

        return response()->json([
            'message' => 'Role permissions updated successfully.',
            'role' => $role->load('permissions')
        ]);
    }
}
