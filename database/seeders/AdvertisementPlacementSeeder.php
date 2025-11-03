<?php

namespace Database\Seeders;

use App\Models\AdvertisementPlacement;
use Illuminate\Database\Seeder;

class AdvertisementPlacementSeeder extends Seeder
{
    public function run(): void
    {
        $placements = [
            [
                'name' => 'Bannière Haut',
                'slug' => 'banniere-haut',
                'code' => 'banner_top',
                'description' => 'Bannière horizontale en haut de page',
                'width' => 728,
                'height' => 90,
                'format' => '728x90',
                'price_per_day' => 10000,
                'billing_type' => 'flat',
                'pages' => ['home', 'article', 'rubrique'],
            ],
            [
                'name' => 'Sidebar Droit',
                'slug' => 'sidebar-droit',
                'code' => 'sidebar',
                'description' => 'Bloc vertical dans la sidebar',
                'width' => 300,
                'height' => 250,
                'format' => '300x250',
                'price_per_day' => 8000,
                'billing_type' => 'flat',
                'pages' => ['article', 'rubrique'],
            ],
            [
                'name' => 'Dans Article',
                'slug' => 'dans-article',
                'code' => 'article',
                'description' => 'Intégré au milieu du contenu',
                'width' => 600,
                'height' => 200,
                'format' => '600x200',
                'price_per_day' => 15000,
                'billing_type' => 'flat',
                'pages' => ['article'],
            ],
            [
                'name' => 'Popup',
                'slug' => 'popup',
                'code' => 'popup',
                'description' => 'Popup après 10 secondes',
                'width' => 400,
                'height' => 300,
                'format' => '400x300',
                'price_per_day' => 20000,
                'billing_type' => 'flat',
                'max_ads' => 2,
                'pages' => ['home', 'article'],
            ],
        ];

        foreach ($placements as $placement) {
            AdvertisementPlacement::create($placement);
        }
    }
}
