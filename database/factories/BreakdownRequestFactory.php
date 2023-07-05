<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Request;
use App\Models\Breakdown;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BreakdownRequest>
 */
class BreakdownRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'request_id' => Request::all()->random()->id,
            'breakdown_id' => Breakdown::all()->random()->id,
        ];
    }
}
