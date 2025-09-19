<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Draw extends Model
{
    use HasUuid;
    protected $table = 'draws';
    protected $fillable = ['lottery_id','draw_at','result_numbers','status'];
    protected $casts = ['result_numbers' => 'array'];

    public function lottery() { return $this->belongsTo(Lottery::class); }
    public function bets() { return $this->hasMany(Bet::class); }
}
