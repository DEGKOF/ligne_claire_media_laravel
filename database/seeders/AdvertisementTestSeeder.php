<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AdvertiserProfile;
use App\Models\Advertisement;
use App\Models\AdvertisementPlacement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdvertisementTestSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer un utilisateur advertiser de test
        $advertiser = User::firstOrCreate(
            ['email' => 'advertiser@test.com'],
            [
                'nom' => 'Test',
                'prenom' => 'Advertiser',
                'username' => 'advertiser_test',
                'password' => Hash::make('password'),
                'role' => 'advertiser',
                'is_active' => true,
                'company_name' => 'Test Company SARL',
                'advertiser_status' => 'active',
            ]
        );

        // 2. Créer son profil advertiser (actif)
        $profile = AdvertiserProfile::firstOrCreate(
            ['user_id' => $advertiser->id],
            [
                'company_name' => 'Test Company SARL',
                'legal_form' => 'SARL',
                'rccm' => 'RB/COT/2024/A/0001',
                'ifu' => '123456789',
                'sector' => 'Technologies',
                'employees_count' => 25,
                'founded_year' => 2020,
                'address' => '123 Avenue de la République, Cotonou',
                'city' => 'Cotonou',
                'country' => 'Bénin',
                'phone' => '+229 12 34 56 78',
                'website' => 'https://testcompany.com',
                'contact_name' => 'Jean Dupont',
                'contact_phone' => '+229 12 34 56 78',
                'contact_email' => 'contact@testcompany.com',
                'contact_position' => 'Directeur Marketing',
                'status' => 'active',
                'validated_at' => now(),
                'validated_by' => 1, // ID du premier admin
                'balance' => 100000, // 100 000 FCFA
            ]
        );

        // 3. Récupérer les emplacements
        $placements = AdvertisementPlacement::all();

        if ($placements->isEmpty()) {
            $this->command->error('Aucun emplacement trouvé ! Lance d\'abord AdvertisementPlacementSeeder');
            return;
        }

        // 4. Créer des campagnes pour chaque emplacement
        foreach ($placements as $placement) {
            Advertisement::create([
                'reference' => 'AD-TEST-' . $placement->code,
                'advertiser_id' => $advertiser->id,
                'placement_id' => $placement->id,
                'name' => 'Campagne Test - ' . $placement->name,
                'description' => 'Campagne de test pour démonstration',

                // Contenu image simple
                'content_type' => 'image',
                'image_path' => 'advertisements/demo-ad.jpg', // Tu devras créer cette image
                'headline' => 'Découvrez nos services !',
                'caption' => 'Test Company - Le meilleur choix pour votre entreprise',
                'cta_text' => 'En savoir plus',
                'target_url' => 'https://testcompany.com',
                'open_new_tab' => true,

                // Période permanente pour test
                'start_date' => now()->subDays(1),
                'end_date' => now()->addMonths(3),
                'is_permanent' => false,

                // Budget
                'budget' => 50000,
                'spent' => 0,
                'daily_budget' => 2000,

                // Pas de ciblage (affichage partout)
                'target_rubriques' => null,
                'target_pages' => null,
                'target_devices' => null,

                // Statut actif
                'status' => 'active',
                'approved_at' => now(),
                'approved_by' => 1,

                // Priorité haute pour test
                'priority' => 10,
            ]);
        }

        $this->command->info('✅ Seeder de test terminé !');
        $this->command->info('📧 Email: advertiser@test.com');
        $this->command->info('🔑 Mot de passe: password');
        $this->command->info('🎯 ' . $placements->count() . ' campagnes actives créées');
    }
}
