# This package for optimize Laravel Init Database Connection

[![Latest Version on Packagist](https://img.shields.io/packagist/v/huy-nguyen/laravel-optimize-init-db-connection.svg?style=flat-square)](https://packagist.org/packages/huy-nguyen/laravel-optimize-init-db-connection)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/huynt57/laravel-optimize-init-db-connection/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/huynt57/laravel-optimize-init-db-connection/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/huy-nguyen/laravel-optimize-init-db-connection.svg?style=flat-square)](https://packagist.org/packages/huy-nguyen/laravel-optimize-init-db-connection)



As mentioned in PR [50044](https://github.com/laravel/framework/pull/50044), this package was implemented for lower Laravel version (PHP >= 7.2, Laravel >= 6)

> "The current code does multiple round-trips to set all the variables we need for our config, both because there are multiple commands to run, but also because it's using prepare, for many of them - each use of prepare and execute causes 3 round trips - one to prepare, one to execute, and one to close statement (on garbage collection of the statement in PHP land). The MySQL SET command supports setting multiple things in a comma separated fashion. Refactoring to do this enables us to just run one SET statement against the server. This can make a real difference in a cloud situation such as AWS Lambda talking to an RDS database where we have to go cross-AZ with low single digit ms latency, instead of sub-ms latency. This also reduces load on the DB (fewer statements to execute), so spinning up a bunch of Lambdas in a burst will be less of a burden."


## Installation

You can install the package via composer:

```bash
composer require huy-nguyen/laravel-optimize-init-db-connection
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-optimize-init-db-connection-config"
```

This is the contents of the published config file:

```php
return [
     'driver' => 'mysql',
];
```

## Usage

As default, this package will change your "mysql" connection. You can setup new database connection by:

Change your configuration (```php config/optimize-init-db-connection.php ```)
```php
return [
     'driver' => 'optimize-mysql',
];
```
Update your driver connection to ```optimize-mysql ```:
```php
'mysql' => [
            'driver' => 'optimize-mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => []
        ],
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [huynt57](https://github.com/huynt57)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
