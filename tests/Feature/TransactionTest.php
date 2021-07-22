<?php

namespace MahbodHastam\UserWallet\Tests\Feature;

use MahbodHastam\UserWallet\Models\UserTransactionModel;
use MahbodHastam\UserWallet\Tests\TestCase;
use MahbodHastam\UserWallet\UserWallet;

class TransactionTest extends TestCase
{
    /** @test */
    public function create_new_transaction_for_two_wallets_and_transfer_values_between_them()
    {
        $wallet1 = UserWallet::createNewWallet(1);
        $wallet2 = UserWallet::createNewWallet(2);

        UserWallet::fill($wallet1, 7000);

        $transaction = UserWallet::send(
            sender: $wallet1,
            receiver: $wallet2,
            value: 5000
        );

        $this->assertEquals(2000, $wallet1->amount);
        $this->assertEquals(5000, $wallet2->amount);
        $this->assertEquals(5000, $transaction->value);
    }

    /** @test */
    public function make_an_open_transaction_request()
    {
        $wallet = UserWallet::createNewWallet(1);
        $transaction = UserWallet::makeRequest(300, $wallet);

        $this->assertEquals(300, $transaction['value']);
        $this->assertEquals($wallet->id, $transaction['receiver_id']);
    }

    /** @test */
    public function make_an_open_transaction_request_and_close_that()
    {
        $wallet1 = UserWallet::createNewWallet(1);
        $transaction = UserWallet::makeRequest(300, $wallet1);

        $wallet2 = UserWallet::createNewWallet(2);
        UserWallet::charge($wallet2, 500);
        UserWallet::closeRequest($wallet2, $transaction['transaction_hash']);

        $this->assertEquals(200, $wallet2->amount);

        $transaction = UserTransactionModel::getTransaction($transaction['transaction_hash']);
        $this->assertTrue(! ! $transaction->is_done);
    }
}
