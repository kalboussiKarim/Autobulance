<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $equipment = [
            [
                'name' => 'Clé à molette',
                'stock' => 10,
            ],
            [
                'name' => 'Lift hydraulique',
                'stock' => 5,
            ],
            [
                'name' => 'Jeu de douilles',
                'stock' => 15,
            ],
            [
                'name' => 'Analyseur de moteur',
                'stock' => 2,
            ],
            [
                'name' => 'Compresseur d air',
                'stock' => 8,
            ],
            [
                'name' => 'Machine de diagnostic électronique',
                'stock' => 3,
            ],
            // Ajoutez d'autres équipements au besoin
        ];

        // Insérer les équipements dans la table
        foreach ($equipment as $item) {
            DB::table('equipment')->insert([
                'name' => $item['name'],
                'stock' => $item['stock'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
