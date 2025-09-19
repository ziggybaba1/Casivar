<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Draw;
use App\Jobs\SettleDrawJob;

class DrawController extends Controller
{
    public function postResult(Request $request, $drawId)
    {
        $request->validate(['result_numbers' => 'required|array']);
        $draw = Draw::findOrFail($drawId);
        if ($draw->status === 'settled') {
            return response()->json(['message' => 'Draw already settled'], 400);
        }

        $draw->result_numbers = $request->result_numbers;
        $draw->status = 'settled';
        $draw->save();

        SettleDrawJob::dispatch($draw);

        return response()->json(['message' => 'Result posted and settlement queued']);
    }
}
