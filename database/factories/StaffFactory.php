<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $positions = ['position1', 'position2', 'position3', 'position4', 'position5', 'position6', 'position7'];
        return [
            'role_id' => Role::all()->random()->id,
            'name' =>  fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => (string) mt_rand(10000000, 99999999),
            'position' => $positions[array_rand($positions)],
            'date_of_birth' => now(),
            'salary' => mt_rand(1000, 9999),
            //'email_verified_at' => now(),
            //'remember_token' => Str::random(10),
        ];
    }
}
