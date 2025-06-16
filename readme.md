# Laravel Role Manager

A comprehensive Laravel package for managing roles and permissions with a beautiful Vue 3 user interface. Built on top of the powerful Spatie Laravel Permission package, this package provides an intuitive web interface for managing your application's authorization system.

## Features

- 🎨 **Beautiful Vue 3 Interface** - Modern, responsive UI built with Tailwind CSS
- 🔐 **Complete Role Management** - Create, edit, delete, and assign roles
- 🛡️ **Permission Management** - Manage permissions with an intuitive interface
- 👥 **User Role Assignment** - Easily assign and remove roles from users
- 📊 **Dashboard Overview** - Get insights into your authorization system
- 🔍 **Search & Filter** - Find roles, permissions, and users quickly
- 📱 **Responsive Design** - Works perfectly on desktop and mobile
- ⚡ **Powered by Spatie's Laravel Permission Package** - Seamless experience
- 🚀 **Easy Installation** - One command setup with automatic configuration

## Requirements

- PHP 8.1+
- Laravel 10.0+
- Node.js & NPM
- Vue 3

## Installation

Install the package via Composer:

```bash
composer require abdallahk/laravel-role-manager
```

Run the installation command:

```bash
php artisan role-manager:install
```

This command will:
- Publish configuration files
- Publish Vue components and assets

Run the migrations:

```bash
php artisan migrate
```

## Configuration

### User Model Setup

Add the `HasRoles` trait to your User model:

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    
    // ... rest of your User model
}
```

### Configuration File

The package publishes a configuration file at `config/role-manager.php`:

```php
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
    | UI Configuration
    |--------------------------------------------------------------------------
    */
    'ui' => [
        'title' => 'Role Manager',
        'theme' => 'default',
        'per_page' => 15,
    ],

    /*
    |--------------------------------------------------------------------------
    | Models Configuration
    |--------------------------------------------------------------------------
    */
    'models' => [
        'user' => \App\Models\User::class,
    ],
];
```

## Usage

### Accessing the Interface

After installation, visit `/role-manager` to access the role management interface.

### Dashboard

The dashboard provides an overview of your authorization system:
- Total roles, permissions, and users
- Recent role activity
- Quick action buttons
- System statistics

### Managing Roles

#### Create a Role
1. Navigate to Roles → Add Role
2. Enter the role name
3. Select permissions for the role
4. Click "Create Role"

#### Edit a Role
1. Go to the Roles page
2. Click "Edit" on the desired role
3. Modify the role name or permissions
4. Click "Update Role"

#### Assign Permissions to Roles
You can assign permissions to roles in two ways:
- During role creation/editing
- Using the bulk permission assignment interface

### Managing Permissions

#### Create a Permission
1. Navigate to Permissions → Add Permission
2. Enter a descriptive permission name
3. Click "Create Permission"

The interface provides common permission examples like:
- `manage users`
- `edit posts`
- `view reports`
- `manage settings`

### User Role Management

#### View Users
The Users section shows all users with their assigned roles.

#### Assign Roles to Users
1. Go to Users → Select a user
2. Choose roles to assign
3. Click "Update User Roles"

#### Remove Roles from Users
1. Navigate to the user's detail page
2. Click "Remove" next to the role you want to remove

## API Usage

The package also provides programmatic access to all functionality:

### Creating Roles

```php
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// Create a role
$role = Role::create(['name' => 'editor']);

// Assign permissions to role
$role->givePermissionTo('edit posts', 'delete posts');

// Or sync permissions
$role->syncPermissions(['edit posts', 'delete posts', 'view posts']);
```

### Creating Permissions

```php
// Create permissions
Permission::create(['name' => 'edit posts']);
Permission::create(['name' => 'delete posts']);
Permission::create(['name' => 'manage users']);
```

### Assigning Roles to Users

```php
use App\Models\User;

$user = User::find(1);

// Assign role
$user->assignRole('editor');

// Assign multiple roles
$user->assignRole(['editor', 'moderator']);

// Sync roles (removes other roles)
$user->syncRoles(['editor']);

// Remove role
$user->removeRole('editor');
```

### Checking Permissions

```php
// Check if user has permission
if ($user->can('edit posts')) {
    // User can edit posts
}

// Check if user has role
if ($user->hasRole('editor')) {
    // User is an editor
}

// Check if user has any of the given roles
if ($user->hasAnyRole(['editor', 'admin'])) {
    // User is either editor or admin
}
```

## Middleware

Use Spatie's middleware to protect routes:

```php
// In your routes file
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

Route::middleware(['permission:manage users'])->group(function () {
    Route::resource('users', UserController::class);
});
```

## Blade Directives

Use blade directives in your templates:

```blade
@role('admin')
    <p>This is visible to users with the admin role.</p>
@endrole

@hasrole('admin')
    <p>This is visible to users with the admin role.</p>
@endhasrole

@permission('edit posts')
    <p>This is visible to users with the edit posts permission.</p>
@endpermission

@hasanyrole('admin|moderator')
    <p>This is visible to users with admin or moderator roles.</p>
@endhasanyrole
```

## Customization

### Styling

The package uses Tailwind CSS. You can customize the appearance by:

1. Publishing the views:
```bash
php artisan vendor:publish --tag=role-manager-views
```

2. Modifying the published Vue components in `resources/views/vendor/role-manager/`

### Routes

You can customize the route prefix and middleware in the configuration file:

```php
'route_prefix' => 'role-manager',
'middleware' => ['web', 'auth', 'role:admin'],
```

### Per Page Items

Customize how many items are shown per page:

```php
'ui' => [
    'per_page' => 25, // Default: 15
],
```

## Security

### Middleware Protection

The package routes are protected by the middleware defined in the configuration. By default, this includes:
- `web` - Web middleware group
- `auth` - Authentication required

Consider adding role-based middleware:

```php
'middleware' => ['web', 'auth', 'role:admin'],
```

### Mass Assignment Protection

All forms use Laravel's validation and mass assignment protection.

### CSRF Protection

All forms include CSRF protection via Inertia.js.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

### Development Setup

1. Clone the repository
2. Install dependencies: `composer install && npm install`
3. Run tests: `composer test`
4. Build assets: `npm run build`

### Running Tests

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- Built on top of [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- Vue 3 for the frontend
- Tailwind CSS for styling
- Laravel framework

## Support

If you discover any security vulnerabilities, please send an e-mail to the package maintainer.

For general support and questions, please use the GitHub issues page.

---

**Laravel Role Manager** - Making role and permission management beautiful and intuitive! 🚀
