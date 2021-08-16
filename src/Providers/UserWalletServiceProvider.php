<?php

namespace Mahbodhastam\UserWallet\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use MahbodHastam\UserWallet\Models\UserWalletModel;

class UserWalletServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerNeededFiles();
        $this->registerBladeDirectives();
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

    protected function registerBladeDirectives(): void
    {
        $this->app->resolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('userWalletBalance', function (
                string | int | UserWalletModel | null $wallet_id_or_token
            ) {
                $wallet = get_wallet(
                    (
                        gettype($wallet_id_or_token) === 'string'
                        && str_starts_with($wallet_id_or_token, '{')
                        && str_ends_with($wallet_id_or_token, '}')
                    )
                    ? json_decode($wallet_id_or_token, true)['id']
                    : $wallet_id_or_token
                );

                // return '<?php echo ' . $wallet["amount"] . '; ?/>';
                return "<?= $wallet->amount ?>";
            });
        });
    }
}
