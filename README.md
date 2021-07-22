# Laravel User Wallet

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mahbodhastam/laravel-user-wallet?include_prereleases&style=for-the-badge)](https://packagist.org/packages/mahbodhastam/laravel-user-wallet)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mahbodhastam/laravel-user-wallet/run-tests?label=tests&style=for-the-badge)](https://github.com/mahbodhastam/laravel-user-wallet/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mahbodhastam/laravel-user-wallet/Check%20&%20fix%20styling?label=code%20style&style=for-the-badge)](https://github.com/mahbodhastam/laravel-user-wallet/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/mahbodhastam/laravel-user-wallet.svg?style=for-the-badge)](https://packagist.org/packages/mahbodhastam/laravel-user-wallet)

---

With this package you can create wallet for the users.

> Note: Make sure you've already installed php ^8

## Installation

Install the package via composer:

```bash
composer require mahbodhastam/laravel-user-wallet
```

## Usage

- #### Create New Wallet

```php
use MahbodHastam\UserWallet\UserWallet;

$wallet = UserWallet::createNewWallet(user_id: 1);

$amount = $wallet->amount;
$token = $wallet->token;
```

- #### Get wallet with the token/id

```php
$wallet = UserWallet::getWallet('abc');
```

- #### Get wallet's balance

```php
$balance = UserWallet::balance($wallet)['total'];
```

- #### Change wallet's amount

```php
UserWallet::fill($wallet, 100);
```

- #### Charge the wallet

```php
UserWallet::charge($wallet, 500);
```

- #### Send

```php
UserWallet::send(
    sender: $wallet1,
    receiver: $wallet2,
    value: 50
);
```

- #### Open a request

```php
$transaction = UserWallet::makeRequest(
    value: 300,
    receiver: $wallet
);

// Keep it
$hash = $transaction->transaction_hash;

UserWallet::closeRequest(
    sender: $wallet,
    transaction_hash: $hash
);
```

> See the [Tests](tests) for more examples.

## Testing

```bash
composer test
```

## Changelog

See [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
