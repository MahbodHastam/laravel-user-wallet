<?php

namespace MahbodHastam\UserWallet\Tests\Feature;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use MahbodHastam\UserWallet\Models\UserWalletModel;
use MahbodHastam\UserWallet\Tests\TestCase;
use MahbodHastam\UserWallet\UserWallet;

class BladeTest extends TestCase
{
    use InteractsWithViews;

    public function setUp(): void
    {
        parent::setUp();

        $walletModel = new UserWalletModel();

        $walletModel->query()->create(['user_id' => 1, 'amount' => 1000]);
    }

    /** @test */
    public function show_user_wallet_balance()
    {
        $wallet = UserWallet::getWallet(wallet_id: 1);

        $renderedView = (string) $this->blade("@userWalletBalance($wallet)");

        $this->assertEquals('1000', trim($renderedView));
    }
}
