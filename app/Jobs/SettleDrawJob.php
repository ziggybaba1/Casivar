<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Draw;
use App\Services\WalletService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SettleDrawJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $draw;

    public function __construct(Draw $draw)
    {
        $this->draw = $draw;
    }

    public function handle(WalletService $walletService)
    {
        $draw = Draw::with('bets')->find($this->draw->id);
        if (!$draw || $draw->status !== 'settled') {
            return;
        }

        $winning = $draw->result_numbers ?? [];

        foreach ($draw->bets as $bet) {
            DB::transaction(function() use ($bet, $winning, $walletService) {
            
                $matched = count(array_intersect($bet->numbers, $winning));
                $matchCount = $matched;

                $ratio = $matchCount > 0 ? bcdiv((string)$matchCount, (string)count($bet->numbers), 8) : '0';
                $payout = bcmul($bet->stake, $bet->odds, 8);
                $payout = bcmul($payout, $ratio, 8);

                if (bccomp($payout, '0', 8) === 1) {
                    // winner
                    $walletService->credit($bet->wallet, (string)$payout, ['type' => 'bet_win', 'bet_id' => $bet->id]);
                    $bet->status = 'won';
                    $bet->payout_meta = [
                        'matched' => $matchCount,
                        'payout' => (string)$payout,
                    ];
                } else {
                    $bet->status = 'lost';
                    $bet->payout_meta = [
                        'matched' => $matchCount,
                        'payout' => '0'
                    ];
                }
                $bet->save();
            });
        }
    }
}
