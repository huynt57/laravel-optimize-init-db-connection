# This package for optimize Laravel Init Database Connection

[![Latest Version on Packagist](https://img.shields.io/packagist/v/huy-nguyen/laravel-optimize-init-db-connection.svg?style=flat-square)](https://packagist.org/packages/huy-nguyen/laravel-optimize-init-db-connection)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/huy-nguyen/laravel-optimize-init-db-connection/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/huy-nguyen/laravel-optimize-init-db-connection/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/huy-nguyen/laravel-optimize-init-db-connection/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/huy-nguyen/laravel-optimize-init-db-connection/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/huy-nguyen/laravel-optimize-init-db-connection.svg?style=flat-square)](https://packagist.org/packages/huy-nguyen/laravel-optimize-init-db-connection)

As mentioned in PR [50044](https://github.com/laravel/framework/pull/50044), this package is for lower Laravel version (PHP >= 7.2, Laravel version >= 6)


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
