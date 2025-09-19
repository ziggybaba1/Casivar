<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\HasUuid;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasUuid;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['name','email','password','role'];
    protected $hidden = ['password'];

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
