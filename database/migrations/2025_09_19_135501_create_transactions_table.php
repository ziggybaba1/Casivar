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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_id');
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 20, 8);
            $table->decimal('balance_after', 20, 8);
            $table->jsonb('meta')->nullable();
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->cascadeOnDelete();
            $table->index(['wallet_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
