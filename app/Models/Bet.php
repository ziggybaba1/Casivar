<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Bet extends Model
{
    use HasUuid;
    protected $table = 'bets';
    protected $fillable = ['user_id', 'wallet_id', 'lottery_id', 'draw_id', 'stake', 'numbers', 'odds', 'potential_payout', 'status', 'payout_meta'];
    protected $casts = [
        'numbers' => 'array',
        'payout_meta' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
    public function draw()
    {
        return $this->belongsTo(Draw::class);
    }
}
