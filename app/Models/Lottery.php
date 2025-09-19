<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Lottery extends Model
{
    use HasUuid;
    protected $table = 'lotteries';
    protected $fillable = ['code','name','country','config'];
    protected $casts = ['config' => 'array'];

    public function draws()
    {
        return $this->hasMany(Draw::class);
    }
}
