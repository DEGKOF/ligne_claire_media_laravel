<?php

namespace Database\Seeders;

use App\Models\Rubrique;
use Illuminate\Database\Seeder;

class RubriquesSeeder extends Seeder
{
    public function run(): void
    {
        $rubriques = [
            [
                'name' => 'Politique',
                'description' => 'Actualité politique nationale et internationale',
                'order' => 1,
                'icon' => '🏛️',
                'color' => '#1e3a8a',
            ],
            [
                'name' => 'Économie',
                'description' => 'Économie, finance et entreprises',
                'order' => 2,
                'icon' => '💼',
                'color' => '#059669',
            ],
            [
                'name' => 'Santé',
                'description' => 'Santé, médecine et bien-être',
                'order' => 3,
                'icon' => '🏥',
                'color' => '#dc2626',
            ],
            [
                'name' => 'Éducation',
                'description' => 'Éducation, formation et recherche',
                'order' => 4,
                'icon' => '📚',
                'color' => '#7c3aed',
            ],
            [
                'name' => 'Tech',
                'description' => 'Technologies, numérique et innovation',
                'order' => 5,
                'icon' => '💻',
                'color' => '#0891b2',
            ],
            [
                'name' => 'Société',
                'description' => 'Faits de société et vie quotidienne',
                'order' => 6,
                'icon' => '👥',
                'color' => '#ea580c',
            ],
            [
                'name' => 'Sport',
                'description' => 'Sports et compétitions',
                'order' => 7,
                'icon' => '⚽',
                'color' => '#16a34a',
            ],
            [
                'name' => 'Culture',
                'description' => 'Culture, arts et spectacles',
                'order' => 8,
                'icon' => '🎭',
                'color' => '#db2777',
            ],
            [
                'name' => 'International',
                'description' => 'Actualité mondiale',
                'order' => 9,
                'icon' => '🌍',
                'color' => '#2563eb',
            ],
            [
                'name' => 'Police-Justice',
                'description' => 'Faits divers et justice',
                'order' => 10,
                'icon' => '⚖️',
                'color' => '#1e40af',
            ],
            [
                'name' => 'People',
                'description' => 'Célébrités et personnalités',
                'order' => 11,
                'icon' => '⭐',
                'color' => '#f59e0b',
            ],
            [
                'name' => 'Météo',
                'description' => 'Prévisions et climat',
                'order' => 12,
                'icon' => '🌤️',
                'color' => '#0ea5e9',
            ],
            [
                'name' => 'Newsletters',
                'description' => 'Nos newsletters',
                'order' => 13,
                'icon' => '📧',
                'color' => '#6366f1',
            ],
            [
                'name' => 'Sondage',
                'description' => 'Sondages et enquêtes',
                'order' => 14,
                'icon' => '📊',
                'color' => '#8b5cf6',
            ],
            [
                'name' => 'Code Promo',
                'description' => 'Bons plans et promotions',
                'order' => 15,
                'icon' => '🎁',
                'color' => '#ec4899',
            ],
        ];

        foreach ($rubriques as $rubrique) {
            Rubrique::create($rubrique);
        }
    }
}
