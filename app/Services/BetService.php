<?php

namespace App\Services;

use App\Models\Bet;
use App\Models\Draw;
use App\Models\Lottery;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Exception;

class BetService
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * place bet: atomic wallet debit + bet creation
     * numbers: array of integers
     * stake: string decimal
     */
    public function placeBet($user, Lottery $lottery, Draw $draw, array $numbers, string $stake): Bet
    {

        if ($draw->status !== 'pending') {
            throw new Exception('Draw not open for betting');
        }
        if ($draw->draw_at <= now()) {
            throw new Exception('Draw already started');
        }

        $odds = $this->determineOdds($lottery, $numbers);

        $potential = bcmul($stake, (string)$odds, 8);

        return DB::transaction(function () use ($user, $lottery, $draw, $numbers, $stake, $odds, $potential) {
            // ensure wallet exists
            $wallet = $user->wallet;
            if (!$wallet) {
                throw new Exception('User wallet not found');
            }

            // debit stake
            $this->walletService->debit($wallet, (string)$stake, ['type' => 'bet_stake', 'lottery' => $lottery->id, 'draw' => $draw->id]);

            $bet = Bet::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'lottery_id' => $lottery->id,
                'draw_id' => $draw->id,
                'stake' => $stake,
                'numbers' => $numbers,
                'odds' => $odds,
                'potential_payout' => $potential,
                'status' => 'pending',
            ]);

            return $bet;
        });
    }

    protected function determineOdds(Lottery $lottery, array $numbers): string
    {
        // implement domain-specific odds mapping here
        $cfg = $lottery->config ?? [];
        // default to 2x odds
        return $cfg['default_odds'] ?? '2.00';
    }
}
