<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OptionChainIndice>
 */
class OptionChainIndiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $count = 0;

        $time = Carbon::parse('2023-08-01 09:00:00', 'Asia/Kolkata')->tz('UTC')->addMinute(10 * $count)->format('Y-m-d H:i:s');

        $count++;

        return [
            'symbol' => 'NIFTY',
            'time' => $time,
            'total_changein_open_interest_ce' => fake()->numberBetween(100000, 500000),
            'total_changein_open_interest_pe' => fake()->numberBetween(100000, 500000),
            'total_open_interest_ce' => fake()->numberBetween(1000000, 2000000),
            'total_open_interest_pe' => fake()->numberBetween(1000000, 2000000),
        ];
    }
}
