<?php
namespace App\Services;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InsufficientFundsException;

class WalletService
{
    public function debit(Wallet $wallet, string $amount, array $meta = []): Transaction
    {
        return DB::transaction(function () use ($wallet, $amount, $meta) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            $current = $wallet->balance;
            if (bccomp($current, $amount, 8) === -1) {
                throw new InsufficientFundsException('Insufficient funds');
            }
            $new = bcsub($current, $amount, 8);
            $wallet->balance = $new;
            $wallet->save();

            return Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $amount,
                'balance_after' => $new,
                'meta' => $meta,
            ]);
        });
    }

    public function credit(Wallet $wallet, string $amount, array $meta = []): Transaction
    {
        return DB::transaction(function () use ($wallet, $amount, $meta) {
            $wallet = Wallet::where('id', $wallet->id)->lockForUpdate()->first();
            $new = bcadd($wallet->balance, $amount, 8);
            $wallet->balance = $new;
            $wallet->save();

            return Transaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'balance_after' => $new,
                'meta' => $meta,
            ]);
        });
    }
}
