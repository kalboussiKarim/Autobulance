<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Breakdown>
 */
class BreakdownFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $breakdownList = ['oilLeak', 'overHeat', 'waterLeak', 'suddenStop', 'unknown'];
        return [
            'breakdown' => $breakdownList[array_rand($breakdownList)],
            'solution' => "solution notice",
            'description' => "help description ",
        ];
    }
}
