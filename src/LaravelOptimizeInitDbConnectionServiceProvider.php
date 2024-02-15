<?php

namespace Huynt57\LaravelOptimizeInitDbConnection;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Connection;

class LaravelOptimizeInitDbConnectionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-optimize-init-db-connection')
            ->hasConfigFile();
        $this->registerDriver();
    }

    private function registerDriver(): void
    {
        $factory = function ($connection, $database, $prefix, $config) {
            return new MySqlConnection($connection, $database, $prefix, $config);
        };

        $driverName = config('optimize-init-db-connection.driver') ?? 'mysql';

        Connection::resolverFor($driverName, $factory);

        $this->app->bind('db.connector.' . $driverName, OptimizedMySqlConnector::class);
    }


}
