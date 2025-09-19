<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\Lottery;
use App\Models\Draw;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PlaceBetTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_place_bet_and_wallet_debits()
    {
        $this->seed(\Database\Seeders\LotterySeeder::class);

        $user = User::factory()->create();
        $user->wallet()->create(['balance' => '100.00']);

        $lottery = Lottery::first();
        $draw = Draw::create(['lottery_id' => $lottery->id, 'draw_at' => now()->addHour()]);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/bets', [
                'lottery_id' => $lottery->id,
                'draw_id' => $draw->id,
                'numbers' => [1,2,3,4,5,6],
                'stake' => '10.00'
            ])->assertStatus(201);

        $this->assertDatabaseHas('bets', ['user_id' => $user->id, 'stake' => '10.00']);
        $this->assertDatabaseHas('wallets', ['user_id' => $user->id, 'balance' => '90.00000000']);
    }
}
