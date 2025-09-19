<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Draw;
use App\Models\Lottery;
use App\Services\BetService;
use Illuminate\Http\Request;

class BetController extends Controller
{
    protected $betService;

    public function __construct(BetService $betService)
    {
        $this->betService = $betService;
    }

    public function place(PlaceBetRequest $request)
    {
        $user = $request->user();
        $lottery = Lottery::findOrFail($request->lottery_id);
        $draw = Draw::findOrFail($request->draw_id);

        $bet = $this->betService->placeBet($user, $lottery, $draw, $request->numbers, (string)$request->stake);

        return response()->json(['bet' => $bet], 201);
    }
}
