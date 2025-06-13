<?php

namespace AbdallahK\LaravelRoleManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->paginate(config('role-manager.ui.per_page', 15));

        return response()->json(compact('permissions'));
    }

    public function create()
    {
        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
        ]);

        $permission = Permission::create(['name' => $request->name]);

        return response()->json([
            'message' => 'Permission created successfully.',
            'permission' => $permission
        ], 201);
    }

    public function show(Permission $permission)
    {
        $permission->load('roles');
        return response()->json(compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return response()->json(compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return response()->json([
            'message' => 'Permission updated successfully.',
            'permission' => $permission
        ]);
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}