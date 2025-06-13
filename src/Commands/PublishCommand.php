<?php

namespace AbdallahK\LaravelRoleManager\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    protected $signature = 'role-manager:publish {--force : Overwrite existing assets}';
    
    protected $description = 'Publish Laravel Role Manager pre-built assets';

    public function handle()
    {
        $this->info('Publishing Laravel Role Manager assets...');

        $this->call('vendor:publish', [
            '--tag' => 'role-manager-assets',
            '--force' => $this->option('force'),
        ]);

        $this->info('✅ Laravel Role Manager assets published successfully!');
        $this->info('📦 Assets published to: public/vendor/role-manager/');
    }
}