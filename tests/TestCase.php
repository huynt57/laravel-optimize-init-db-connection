<?php

namespace Huynt57\LaravelOptimizeInitDbConnection\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Huynt57\LaravelOptimizeInitDbConnection\LaravelOptimizeInitDbConnectionServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Huynt57\\LaravelOptimizeInitDbConnection\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelOptimizeInitDbConnectionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-optimize-init-db-connection_table.php.stub';
        $migration->up();
        */
    }
}
