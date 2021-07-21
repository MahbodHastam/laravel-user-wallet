<?php

namespace MahbodHastam\UserWallet\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class create_users_wallets_table extends Migration {

    public function up() {
        Schema::create('uw_wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('amount')->default(0);
            $table->text('token')->default(createHash());
            $table->timestamps();
        });

        Schema::create('uw_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('receiver_id');
            $table->bigInteger('value');
            $table->text('transaction_hash')->default(createHash());
            $table->boolean('is_done')->default(false);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('uw_transactions');
        Schema::dropIfExists('uw_wallets');
    }
}
