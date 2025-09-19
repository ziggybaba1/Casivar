<?php

namespace Database\Seeders;

use App\Models\Lottery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LotterySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Lottery::create([
            'code' => 'MEGA',
            'name' => 'Mega Lottery',
            'country' => 'Global',
            'config' => ['default_odds' => '2.00', 'numbers_count' => 6]
        ]);

        Lottery::create([
            'code' => 'EURO',
            'name' => 'Euro Lottery',
            'country' => 'EU',
            'config' => ['default_odds' => '1.50', 'numbers_count' => 5]
        ]);
    }
}
