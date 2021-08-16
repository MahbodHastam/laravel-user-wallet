<?php

namespace MahbodHastam\UserWallet\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserWalletModel
 * @package MahbodHastam\UserWallet\Models
 * @method static Model getByToken(int|string $token)
 * @method static UserWalletModel createNewWallet(int $user_id)
 */
class UserWalletModel extends Model
{
    protected $table = 'uw_wallets';

    protected $guarded = [];

    public function scopeCreateNewWallet(EloquentBuilder $query, int $user_id): Model | EloquentBuilder | EloquentCollection | array | null
    {
        $wallet = $query->create(['user_id' => $user_id]);

        return $query->find($wallet['id']);
    }

    public function scopeGetByToken(EloquentBuilder $query, string $token): Model | null
    {
        return $query->where('token', $token)->first();
    }

    public static function getWallet(int | string | UserWalletModel | null $wallet_id_or_token): UserWalletModel | Model | null
    {
        return get_wallet($wallet_id_or_token);
    }

    public static function getBalance(UserWalletModel | string | int $wallet): int | null
    {
        return UserWalletModel::getWallet($wallet)->amount;
    }

    public static function createNewTransaction(array $data): UserTransactionModel | EloquentBuilder | EloquentCollection | Model | array | null
    {
        $receiver = UserWalletModel::getWallet($data['receiver']);
        $sender = UserWalletModel::getWallet($data['sender']);

        if ($sender) {
            if ($sender->amount <= 0 && ($sender->amount - $data['value']) < 0) {
                throw new \Error('Sender wallet\'s amount is not enough.');
            }
        }

        $receiver->update([
            'amount' => (int) $receiver->amount + (int) $data['value'],
        ]);

        if ($sender) {
            $sender->update([
                'amount' => (int) $sender->amount - (int) $data['value'],
            ]);
        }

        $transaction = UserTransactionModel::query()->create([
            'sender_id' => $sender->id ?? null,
            'receiver_id' => $receiver->id,
            'value' => $data['value'],
            'is_done' => $data['is_done'] ?? false,
        ]);

        return UserTransactionModel::query()->find($transaction['id']);
    }
}
