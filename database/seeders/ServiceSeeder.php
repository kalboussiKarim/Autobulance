<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service ;
use Illuminate\Support\Facades\DB;
class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Changement d\'huile',
                'price' => 50.00,
            ],
            [
                'name' => 'Réparation de freins',
                'price' => 120.00,
            ],
            [
                'name' => 'Changement de pneus',
                'price' => 80.00,
            ],
            [
                'name' => 'Diagnostic moteur',
                'price' => 150.00,
            ],
            [
                'name' => 'Alignement des roues',
                'price' => 70.00,
            ],
            [
                'name' => 'Réparation de la climatisation',
                'price' => 100.00,
            ],
            [
                'name' => 'Remplacement de la batterie',
                'price' => 90.00,
            ],
            [
                'name' => 'Réparation de la transmission',
                'price' => 200.00,
            ],
            [
                'name' => 'Vidange du liquide de refroidissement',
                'price' => 60.00,
            ],
            [
                'name' => 'Diagnostic électrique',
                'price' => 130.00,
            ],
            // Ajoutez d'autres services au besoin
        ];
         foreach ($services as $service) {
            DB::table('services')->insert([
                'name' => $service['name'],
                'price' => $service['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
