<?php
// database/migrations/2024_11_13_create_memberships_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();

            // Formule d'engagement
            $table->enum('formule', ['citoyen', 'ambassadeur'])->default('citoyen');

            // Informations personnelles
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone'); // WhatsApp

            // Paiement
            $table->enum('mode_paiement', ['mobile_money', 'carte_bancaire', 'crypto']);
            $table->enum('frequence', ['mensuel', 'trimestriel', 'semestriel', 'annuel'])->default('mensuel');
            $table->decimal('montant', 10, 2); // 5000 ou 10000 FCFA

            // Préférences de visibilité
            $table->boolean('apparaitre_publiquement')->default(false);

            // Statut et suivi
            $table->enum('statut', ['en_attente', 'actif', 'suspendu', 'expire'])->default('en_attente');
            $table->date('date_adhesion')->nullable();
            $table->date('date_expiration')->nullable();
            $table->integer('annees_soutien')->default(0); // Pour le droit de vote après 3 ans

            // Carte de membre
            $table->string('numero_carte')->unique()->nullable();

            // Acceptation de la charte
            $table->boolean('charte_acceptee')->default(false);
            $table->timestamp('charte_acceptee_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
