<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Transaction extends Model
{
    use HasUuid;
    protected $table = 'transactions';
    protected $fillable = ['wallet_id','type','amount','balance_after','meta'];
    protected $casts = [
        'meta' => 'array'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
