<?php

namespace Huynt57\LaravelOptimizeInitDbConnection;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Connection;

class LaravelOptimizeInitDbConnectionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configFileName = 'optimize-init-db-connection';
        $this->mergeConfigFrom(__DIR__ . "/../config/{$configFileName}.php", $configFileName);
        $this->registerDriver();
    }

    public function boot()
    {
        $configFileName = 'optimize-init-db-connection';
        $this->publishes([
            __DIR__ . "/../config/{$configFileName}.php" => config_path('optimize-init-db-connection.php'),
        ]);
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
