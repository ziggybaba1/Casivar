<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    //
}
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUuid;

class Wallet extends Model
{
    use HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['user_id', 'balance'];
    protected $table = 'wallets';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
