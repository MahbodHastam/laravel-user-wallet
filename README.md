# Laravel User Wallet

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mahbodhastam/laravel-user-wallet.svg?style=flat-square)](https://packagist.org/packages/mahbodhastam/laravel-user-wallet)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mahbodhastam/laravel-user-wallet/run-tests?label=tests)](https://github.com/mahbodhastam/laravel-user-wallet/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mahbodhastam/laravel-user-wallet/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mahbodhastam/laravel-user-wallet/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/mahbodhastam/laravel-user-wallet.svg?style=flat-square)](https://packagist.org/packages/mahbodhastam/laravel-user-wallet)

---

With this package you can create wallet for the users.

> Note: Make sure you've already installed php ^8

## Installation

Install the package via composer:

```bash
composer require mahbodhastam/laravel-user-wallet
```

## Usage

```php
use MahbodHastam\UserWallet\UserWallet;

$wallet = UserWallet::createNewWallet();

$amount = $wallet->amount;
$token = $wallet->token;
```

## Testing

```bash
composer test
```

## Changelog

See [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

<!--
## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.
-->

## Credits

- [MahbodHastam](https://github.com/MahbodHastam)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
