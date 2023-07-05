<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $req_type = ['EMERGENCY', 'PLANNED'];
        $car_types = ['mercedes', 'bmw', 'peugeot', 'citroen', 'fiat'];
        return [
            'client_id' => Client::all()->random()->id,
            'car_type' => $car_types[array_rand($car_types)],
            'matricule' => (string) mt_rand(10000000, 99999999),
            'latitude' => (string) mt_rand(10, 99) . '.' . (string) mt_rand(10000, 99999) . ', ' . (string) mt_rand(1, 9) . '.' . (string) mt_rand(10000, 99999),
            'longitude' => (string) mt_rand(10, 99) . '.' . (string) mt_rand(10000, 99999) . ', ' . (string) mt_rand(1, 9) . '.' . (string) mt_rand(10000, 99999),
            'request_type' => $req_type[array_rand($req_type)],
            'date' => now(),

        ];
    }
}
