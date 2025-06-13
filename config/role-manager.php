<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    */
    'route_prefix' => 'role-manager',

    'middleware' => ['web', 'auth'],

    /*
    |--------------------------------------------------------------------------
    | Authorization Configuration
    |--------------------------------------------------------------------------
    | Configure how users are authorized to access the role manager UI.
    | Multiple methods can be used simultaneously.
    */
    'authorization' => [
        // Allow specific user IDs
        'allowed_user_ids' => [
            1,
            2,
            3 // Add specific user IDs here
        ],

        // Allow users from specific email domains
        'allowed_domains' => [
            // 'yourcompany.com',
            // 'admin.yoursite.com'
        ],

        // Required role names (if using role-based authorization)
        'required_roles' => [
            'admin',
            'super-admin'
        ],

        // Additional required permission names (beyond the default manage_roles)
        'required_permissions' => [
            // 'access-admin-panel'
        ],

        // Custom authorization callback
        'custom_callback' => null,
        // Example:
        // 'custom_callback' => function ($user) {
        //     return $user->isAdmin() && $user->hasVerifiedEmail();
        // },
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Configuration
    |--------------------------------------------------------------------------
    */
    'ui' => [
        'title' => 'Role Manager',
        'show_docs' => true,
        'theme' => 'default',
        'per_page' => 15,
        'home_url' => '/dashboard' // update it to overwrite the back to application link
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions Configuration
    |--------------------------------------------------------------------------
    */
    'permissions' => [
        'manage_roles' => 'manage roles',
        'manage_permissions' => 'manage permissions',
        'assign_roles' => 'assign roles to users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Models Configuration
    |--------------------------------------------------------------------------
    */
    'models' => [
        'user' => \App\Models\User::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Version
    |--------------------------------------------------------------------------
    */
    'version' => '1.0.0',
];
