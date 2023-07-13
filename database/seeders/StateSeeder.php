<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;
class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            ['status' => 'busy'],
            ['status' => 'break_down'],
            ['status' => 'available'],
            
        ];

        foreach ($status as $state) {
            State::create($state);
        }
    }
}
