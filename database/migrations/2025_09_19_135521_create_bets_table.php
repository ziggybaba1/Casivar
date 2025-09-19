<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('wallet_id');
            $table->uuid('lottery_id');
            $table->uuid('draw_id');
            $table->decimal('stake', 20, 8);
            $table->jsonb('numbers'); // player's chosen numbers
            $table->decimal('odds', 20, 8)->default(1);
            $table->decimal('potential_payout', 20, 8)->nullable();
            $table->enum('status', ['pending', 'won', 'lost', 'cancelled'])->default('pending');
            $table->jsonb('payout_meta')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('wallet_id')->references('id')->on('wallets')->cascadeOnDelete();
            $table->foreign('lottery_id')->references('id')->on('lotteries')->cascadeOnDelete();
            $table->foreign('draw_id')->references('id')->on('draws')->cascadeOnDelete();

            $table->index(['user_id', 'draw_id', 'lottery_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bets');
    }
};
