<?php

namespace MahbodHastam\UserWallet\Tests;

use Illuminate\Foundation\Application;
use MahbodHastam\UserWallet\Database\Migrations\create_users_wallets_table;
use MahbodHastam\UserWallet\Models\UserWalletModel;
use MahbodHastam\UserWallet\Providers\UserWalletServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
//    public UserWalletModel $model;

    public function setUp(): void
    {
        parent::setUp();

//        $this->model = new UserWalletModel;

        $this->setupDatabase();
    }

    /**
     * Get package providers
     *
     * @param Application $app
     * @return array|void
     */
    protected function getPackageProviders($app)
    {
        return [
            UserWalletServiceProvider::class,
        ];
    }

    /**
     * Define environment setup
     *
     * @param Application $app
     */
    public function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'luwalletdb');
        $app['config']->set('database.connections.luwalletdb', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
    }

    /**
     * Setup database
     */
    public function setupDatabase(): void
    {

        // Run migrations
        (new create_users_wallets_table())->up();
    }
}
