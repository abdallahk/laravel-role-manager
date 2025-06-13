<?php

namespace AbdallahK\LaravelRoleManager\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelRoleManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-role-manager';
    }
}
