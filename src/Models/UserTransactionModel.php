<?php

namespace MahbodHastam\UserWallet\Models;

use Illuminate\Database\Eloquent\Model;
use MahbodHastam\UserWallet\UserWallet;

class UserTransactionModel extends Model
{
    protected $table = 'uw_transactions';

    protected $guarded = [];

    public static function getTransaction(string | int | UserTransactionModel $transaction): UserTransactionModel | Model | null
    {
        if ($transaction instanceof UserTransactionModel) {
            return $transaction;
        }

        if (in_array(gettype($transaction), ['string', 'integer'])) {
            $findTransaction = UserTransactionModel::query()->find($transaction);

            if (! $findTransaction) {
                $findTransaction = UserTransactionModel::query()->where('transaction_hash', $transaction)->first();
            }
        }

        if (! $findTransaction) {
            throw new \Error("Something went wrong: Transaction not found.");
        }

        return $findTransaction;
    }

    public static function closeTransaction(int | string | UserWalletModel $sender, string $transaction_hash): UserTransactionModel
    {
        $transaction = UserTransactionModel::getTransaction($transaction_hash);
        $sender_wallet = UserWalletModel::getWallet($sender);

        if ($sender_wallet->amount <= 0 && ($sender_wallet->amount - $transaction->value) < 0) {
            throw new \Error('Sender wallet\'s amount is not enough.');
        }

//        UserWallet::fill($sender_wallet, $sender_wallet->amount - $transaction->value);
        UserWallet::withdrawal($sender_wallet, $transaction->value);

        $receiver_wallet = UserWalletModel::getWallet($transaction->receiver_id);
        UserWallet::charge($receiver_wallet, $transaction->value);

        $transaction->update([
            'sender_id' => $sender_wallet->id,
            'is_done' => true,
        ]);

        return $transaction;
    }
}
