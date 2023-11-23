<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Breakdown;

class BreakdownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $breakdowns = [
             [
        "breakdown" => "autre",
        "solution" => "autre non definit",
        "description" => "a etablir ",
    ], [
        "breakdown" => "Batterie déchargée",
        "solution" => "Rechargez la batterie ou remplacez-la si nécessaire.",
        "description" => "La voiture ne démarre pas, et les lumières sont faibles.",
    ],
    [
        "breakdown" => "Pneu crevé",
        "solution" => "Changez le pneu avec la roue de secours ou appelez une dépanneuse.",
        "description" => "La voiture perd de l'air ou a un pneu à plat.",
    ],
    [
        "breakdown" => "Problème de démarrage",
        "solution" => "Vérifiez le démarreur, la batterie et le système d'allumage.",
        "description" => "Le moteur tourne, mais la voiture ne démarre pas.",
    ],
    [
        "breakdown" => "Surchauffe du moteur",
        "solution" => "Laissez le moteur refroidir, vérifiez le niveau de liquide de refroidissement.",
        "description" => "La jauge de température indique une surchauffe du moteur.",
    ],
    [
        "breakdown" => "Alternateur défectueux",
        "solution" => "Remplacez l'alternateur pour assurer la charge de la batterie.",
        "description" => "La batterie ne se recharge pas correctement pendant que la voiture est en marche.",
    ],
    [
        "breakdown" => "Rupture de courroie de distribution",
        "solution" => "Remplacez la courroie de distribution dès que possible pour éviter des dommages au moteur.",
        "description" => "La voiture émet un bruit de cliquetis provenant du moteur, et la performance diminue.",
    ],
        ];
          foreach ($breakdowns as $breakdown) {
            Breakdown::create($breakdown);
    }
    }
}
