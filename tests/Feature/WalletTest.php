<?php

namespace MahbodHastam\UserWallet\Tests\Feature;

use MahbodHastam\UserWallet\Models\UserWalletModel;
use MahbodHastam\UserWallet\Tests\TestCase;
use MahbodHastam\UserWallet\UserWallet;

class WalletTest extends TestCase {
    /** @test */
    public function model_works_fine() {
        $wallet = UserWalletModel::query()->create(['user_id' => 1, 'amount' => 5000]);

        $this->assertEquals(1, $wallet->user_id);
    }

    /** @test */
    public function create_new_wallet() {
        $wallet = UserWallet::createNewWallet(1);

        $this->assertEquals($wallet instanceof UserWalletModel, !!$wallet);
    }

    /** @test */
    public function get_wallet_balance_with_model_instance_token_and_id() {
        $wallet = UserWallet::createNewWallet(1);
        $amountShouldBe = 100;

        $wallet->update([
            'amount' => $amountShouldBe,
        ]);

        $this->assertEquals(collect(['total' => $amountShouldBe]), UserWallet::balance($wallet->id));
        $this->assertEquals(collect(['total' => $amountShouldBe]), UserWallet::balance($wallet->token));
        $this->assertEquals(collect(['total' => $amountShouldBe]), UserWallet::balance($wallet));
    }

    /** @test */
    public function create_new_wallet_and_fill_it() {
        $wallet = UserWallet::createNewWallet(1);

        $walletChanged = UserWallet::fill($wallet, 3000);

        $this->assertEquals($wallet->amount, $walletChanged->amount);
    }

    /** @test */
    public function create_new_wallet_and_charge_it() {
        $wallet = UserWallet::createNewWallet(1);

        $walletChanged = UserWallet::fill($wallet, 3000);
        $this->assertEquals($wallet->amount, $walletChanged->amount);

        $walletChanged = UserWallet::charge($walletChanged, 3000);
        $this->assertEquals(6000, $walletChanged->amount);
    }
}
