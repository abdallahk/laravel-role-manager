<?php

namespace AbdallahK\LaravelRoleManager\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    protected $signature = 'role-manager:install {--force : Overwrite existing files}';

    protected $description = 'Install Laravel Role Manager package';

    public function handle()
    {
        $this->info('Installing Laravel Role Manager...');

        // Publish configuration
        $this->call('vendor:publish', [
            '--tag' => 'role-manager-config',
            '--force' => $this->option('force', false),
        ]);

        // Publish Application Service Provider
        $this->call('vendor:publish', [
            '--tag' => 'role-manager-provider',
            '--force' => $this->option('force', false),
        ]);

        // Publish pre-built assets
        $this->call('vendor:publish', [
            '--tag' => 'role-manager-assets',
            '--force' => $this->option('force', false),
        ]);

        // Install Spatie Laravel Permission if not already installed
        if (!$this->isPackageInstalled('spatie/laravel-permission')) {
            $this->info('Installing Spatie Laravel Permission...');
            $this->call('vendor:publish', [
                '--provider' => 'Spatie\Permission\PermissionServiceProvider',
                '--tag' => 'permission-migrations',
            ]);
        }

        $this->info('✅ Laravel Role Manager installed successfully!');
        $this->info('');
        $this->info('📦 Pre-built Vite assets published to public/vendor/role-manager/');
        $this->info('🔐 Authorization service provider published to app/Providers/');
        $this->info('');
        $this->info('🚀 Next steps:');
        $this->info('1. Run: php artisan migrate');
        $this->info('2. Add the HasRoles trait to your User model');
        $this->info('3. Visit /role-manager to start managing roles and permissions');
        $this->info('');
        $this->info('💡 Authorization options:');
        $this->info('   • Config-based: Edit config/role-manager.php');
        $this->info('   • Email whitelist: Edit the service provider');
        $this->info('   • Custom logic: Use custom callback');
    }

    protected function isPackageInstalled($package)
    {
        $composer = json_decode(file_get_contents(base_path('composer.json')), true);
        return isset($composer['require'][$package]) || isset($composer['require-dev'][$package]);
    }
}
