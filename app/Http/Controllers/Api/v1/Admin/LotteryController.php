<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lottery;

class LotteryController extends Controller
{
    //
    public function index()
    {
        return Lottery::paginate(20);
    }
    public function store(Request $r)
    {
        $r->validate(['code' => 'required|unique:lotteries,code', 'name' => 'required']);
        $lottery = Lottery::create($r->only(['code', 'name', 'country']) + ['config' => $r->input('config', [])]);
        return response()->json($lottery, 201);
    }
    public function show(Lottery $lottery)
    {
        return $lottery;
    }
    public function update(Request $r, Lottery $lottery)
    {
        $lottery->update($r->only(['name', 'country']) + ['config' => $r->input('config', $lottery->config)]);
        return $lottery;
    }
    public function destroy(Lottery $lottery)
    {
        $lottery->delete();
        return response()->noContent();
    }
}
