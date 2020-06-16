# Laravel Login Attempts

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lamalama/laravel-login-attempts.svg?style=flat-square)](https://packagist.org/packages/lamalama/laravel-login-attempts)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![StyleCI](https://github.styleci.io/repos/268217938/shield?branch=master)](https://github.styleci.io/repos/268217938)
[![Total Downloads](https://img.shields.io/packagist/dt/lamalama/laravel-login-attempts.svg?style=flat-square)](https://packagist.org/packages/lamalama/laravel-login-attempts)

Register unique login attempts and get notified of suspicious attempts via email.

## Install

Via Composer

``` bash
$ composer require lamalama/laravel-login-attempts
```

You can publish the migration with:
```bash
php artisan vendor:publish --provider="LamaLama\LoginAttempts\LoginAttemptsServiceProvider" --tag="migrations"
```

After publishing the migration you can create the `login_attempts` table by running the migrations:

```bash
php artisan migrate
```

You can optionally publish the config file with:
```bash
php artisan vendor:publish --provider="LamaLama\LoginAttempts\LoginAttemptsServiceProvider" --tag="config"
```

## Use

Add the ```LamaLama\LoginAttempts\Listeners\AuthEventSubscriber``` to the ```$subscribe``` variable in the ```app/Providers/EventServiceProvider.php``` file.

```php
/**
 * The subscriber classes to register.
 *
 * @var array
 */
protected $subscribe = [
    'LamaLama\LoginAttempts\Listeners\AuthEventSubscriber',
];
```

Set the email addresses which shoud receive notifications in your .env file:

```
LOGIN_ATTEMPTS_EMAIL="laravel@lamalama.nl, laravel@lamalama.com"
```

### Commands

Clear all login attempts in the database
```bash
php artisan login-attempts:clear
```

Clear all failed login attempts in the database
```bash
php artisan login-attempts:clear-failed
```

Clear all login succeeded attempts in the database
```bash
php artisan login-attempts:clear-succeeded
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Lama Lama](https://github.com/lamalamaNL)
- [Mark de Vries](https://github.com/lamalamaMark)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
