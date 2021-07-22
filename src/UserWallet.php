<?php

namespace MahbodHastam\UserWallet;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use MahbodHastam\UserWallet\Models\UserTransactionModel;
use MahbodHastam\UserWallet\Models\UserWalletModel;

class UserWallet
{
    public static function createNewWallet(int $user_id): UserWalletModel
    {
        return UserWalletModel::createNewWallet($user_id);
    }

    public static function getWallet(int|string $wallet_id): Model | UserWalletModel | null {
        return UserWalletModel::getWallet($wallet_id);
    }

    public static function balance(UserWalletModel | string | int $wallet): Collection
    {
        return collect([
            'total' => UserWalletModel::getBalance($wallet),
        ]);
    }

    public static function fill($wallet, int $amount): Model | UserWalletModel
    {
        $wallet = UserWalletModel::getWallet($wallet);

        $wallet->update([
            'amount' => $amount,
        ]);

        return $wallet;
    }

    public static function charge($wallet, int $amount): Model | UserWalletModel
    {
        $wallet = UserWalletModel::getWallet($wallet);

        $wallet->update([
            'amount' => (int) $wallet->amount + $amount,
        ]);

        return $wallet;
    }

    public static function withdrawal($wallet, int $amount): Model | UserWalletModel | null
    {
        $wallet = UserWalletModel::getWallet($wallet);

        if (($wallet->amount - $amount) < 0) {
            return $wallet;
        }

        $wallet->update([
            'amount' => $wallet->amount - $amount,
        ]);

        return $wallet;
    }

    public static function send(int | string | UserWalletModel | null $sender, int | string | UserWalletModel $receiver, int $value): UserTransactionModel | Model | EloquentBuilder | EloquentCollection | array | null
    {
        return UserWalletModel::createNewTransaction([
            'sender' => $sender,
            'receiver' => $receiver,
            'value' => $value,
            'is_done' => true,
        ]);
    }

    public static function makeRequest(int $value, int | string | UserWalletModel $receiver): Collection
    {
        $transaction = UserWalletModel::createNewTransaction([
            'sender' => null,
            'receiver' => $receiver,
            'value' => $value,
        ]);

        return collect([
            'transaction_hash' => $transaction['transaction_hash'],
            'value' => $value,
            'receiver_id' => $receiver->id,
        ]);
    }

    public static function closeRequest(int | string | UserWalletModel $sender, string $transaction_hash): UserTransactionModel
    {
        return UserTransactionModel::closeTransaction($sender, $transaction_hash);
    }
}
