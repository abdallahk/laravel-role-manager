<?php

namespace AbdallahK\LaravelRoleManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'user' => Auth::user(),
            'roles_count' => Role::count(),
            'permissions_count' => Permission::count(),
            'users_count' => config('role-manager.models.user')::count(),
            'recent_roles' => Role::latest()->take(5)->get(),
            'settings' => [
                'home' => config('role-manager.route_prefix'),
            ]
        ];

        if (request()->wantsJson()) {
            return response()->json(compact('stats'));
        }

        return view('role-manager::app');
    }
}