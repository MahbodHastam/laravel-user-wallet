<?php

namespace Mahbodhastam\UserWallet\Providers;

use Illuminate\Support\ServiceProvider;

class UserWalletServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerNeededFiles();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/users_wallets.php', 'users-wallets');
    }

    protected function registerNeededFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/users_wallets.php' => config_path('users_wallets.php'),
        ], 'config');

        if (! class_exists('CreateUsersWalletTable')) {
            $this->publishes([
                __DIR__ . '/../../database/migrations/create_users_wallet_table.php' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_users_wallets_table.php'),
            ], 'migrations');
        }
    }
}
