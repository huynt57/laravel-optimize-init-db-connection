<?php

namespace Huynt57\LaravelOptimizeInitDbConnection\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Huynt57\LaravelOptimizeInitDbConnection\LaravelOptimizeInitDbConnection
 */
class LaravelOptimizeInitDbConnection extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Huynt57\LaravelOptimizeInitDbConnection\LaravelOptimizeInitDbConnection::class;
    }
}
