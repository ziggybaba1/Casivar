<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    //
    public function show()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        return response()->json(['balance' => $wallet ? $wallet->balance : 0]);
    }
}
