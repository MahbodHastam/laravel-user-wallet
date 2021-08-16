<?php

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use MahbodHastam\UserWallet\Models\UserWalletModel;

if (!function_exists('createHash')) {
    function createHash(): string
    {
        return hash('sha256', uniqid((string) time()));
    }
}

if (!function_exists('get_wallet')) {
    function get_wallet(string | int | UserWalletModel | null $wallet_id_or_token): UserWalletModel | Model | EloquentBuilder | null
    {
        if ($wallet_id_or_token instanceof UserWalletModel) {
            return $wallet_id_or_token;
        }

        if (is_null($wallet_id_or_token)) {
            return null;
        }

        if (in_array(gettype($wallet_id_or_token), ['string', 'integer'])) {
            $wallet = UserWalletModel::query()->find($wallet_id_or_token);

            if (!$wallet) {
                $wallet = UserWalletModel::getByToken($wallet_id_or_token);
            }
        }

        if (!$wallet) {
            throw new \Error('Something went wrong: Wallet not found.');
        }

        return $wallet;
    }
}
