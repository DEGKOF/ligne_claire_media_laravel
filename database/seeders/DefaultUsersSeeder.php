<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Master Admin
        User::create([
            'nom' => 'Admin',
            'prenom' => 'Master',
            'username' => 'masteradmin',
            'email' => 'admin@ligneclairemedia.com',
            'password' => Hash::make('password'), // À CHANGER EN PRODUCTION !
            'display_name' => 'Rédaction LCM+',
            'role' => 'master_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Admin
        User::create([
            'nom' => 'Administrateur',
            'prenom' => 'Principal',
            'username' => 'admin',
            'email' => 'redaction@ligneclairemedia.com',
            'password' => Hash::make('password'),
            'display_name' => 'Équipe LCM+',
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Rédacteur
        User::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'username' => 'jdupont',
            'email' => 'j.dupont@ligneclairemedia.com',
            'password' => Hash::make('password'),
            'display_name' => 'Jean Dupont',
            'role' => 'redacteur',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Journaliste
        User::create([
            'nom' => 'Martin',
            'prenom' => 'Sophie',
            'username' => 'smartin',
            'email' => 's.martin@ligneclairemedia.com',
            'password' => Hash::make('password'),
            'display_name' => 'Sophie Martin',
            'role' => 'journaliste',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
    }
}
