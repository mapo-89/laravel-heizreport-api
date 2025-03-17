# laravel heizreport api

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mapo-89/heizreportapi.svg?style=flat-square)](https://packagist.org/packages/mapo-89/heizreportapi)
[![Total Downloads](https://img.shields.io/packagist/dt/mapo-89/heizreportapi.svg?style=flat-square)](https://packagist.org/packages/mapo-89/heizreportapi)
![GitHub Actions](https://github.com/mapo-89/heizreportapi/actions/workflows/main.yml/badge.svg)

This package make a connection to the heizreport api and let you interact with it.

[Heizreport API Documentation](https://heizreport.com/hilfethemen/schnittstellen)

## Installation

You can install the package via composer:

```bash
composer require mapo-89/laravel-heizreport-api
```
Set your api token with

```
HEIZREPORT_API_TOKEN=xxxxxxxx
```

Optionally you can publish the config file with:

```bash
php artisan vendor:publish --provider="Mapo89\LaravelHeizreportApi\HeizreportApiServiceProvider" --tag="config"
```

## Usage

```php
// Usage description here
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email info@postler.de instead of using the issue tracker.

## Credits

-   [Manuel Postler](https://github.com/mapo-89)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
