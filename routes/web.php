<?php

use AbdallahK\LaravelRoleManager\Http\Controllers\RoleController;
use AbdallahK\LaravelRoleManager\Http\Controllers\PermissionController;
use AbdallahK\LaravelRoleManager\Http\Controllers\UserRoleController;
use AbdallahK\LaravelRoleManager\Http\Controllers\DashboardController;
use AbdallahK\LaravelRoleManager\LaravelRoleManager;
use Illuminate\Support\Facades\Route;

// API Routes ONLY - these must be protected from catch-all
Route::prefix('api')->group(function () {
    // Dashboard - accessible to anyone with role manager access
    Route::get('/', [DashboardController::class, 'index']);

    // Roles Management Routes
    Route::group(['prefix' => 'roles'], function () {
        // All operations - main authorization already handled by Authorize middleware
        Route::get('/', [RoleController::class, 'index']);
        Route::get('/create', [RoleController::class, 'create']);
        Route::get('/{role}', [RoleController::class, 'show']);
        Route::get('/{role}/edit', [RoleController::class, 'edit']);
        Route::get('/{role}/users', [RoleController::class, 'getRoleUsers']);
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::patch('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);
        Route::post('/{role}/permissions', [RoleController::class, 'updatePermissions']);
    });

    // Permissions Management Routes
    Route::group(['prefix' => 'permissions'], function () {
        // All operations - main authorization already handled by Authorize middleware
        Route::get('/', [PermissionController::class, 'index']);
        Route::get('/create', [PermissionController::class, 'create']);
        Route::get('/{permission}', [PermissionController::class, 'show']);
        Route::get('/{permission}/edit', [PermissionController::class, 'edit']);
        Route::post('/', [PermissionController::class, 'store']);
        Route::put('/{permission}', [PermissionController::class, 'update']);
        Route::patch('/{permission}', [PermissionController::class, 'update']);
        Route::delete('/{permission}', [PermissionController::class, 'destroy']);
    });

    // User Role Management Routes
    Route::group(['prefix' => 'users'], function () {
        // All operations - main authorization already handled by Authorize middleware
        Route::get('/', [UserRoleController::class, 'index']);
        Route::get('/{user}', [UserRoleController::class, 'show']);
        Route::post('/{user}/roles', [UserRoleController::class, 'assignRoles']);
        Route::delete('/{user}/roles/{role}', [UserRoleController::class, 'removeRole']);
    });
});

// SPA Routes - all non-API routes serve the Vue app
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');