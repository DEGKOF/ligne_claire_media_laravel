// database/migrations/2024_11_13_create_memberships_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->enum('type_membre', ['individuel', 'association', 'entreprise']);
            $table->enum('civilite', ['M.', 'Mme', 'Mlle'])->nullable();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('nom_association')->nullable();
            $table->string('nom_entreprise')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite');
            $table->string('profession');
            $table->text('adresse_postale');
            $table->string('telephone');
            $table->string('email');
            $table->decimal('montant', 10, 2);
            $table->enum('mode_paiement', ['mobile_money', 'virement', 'especes']);
            $table->enum('status', ['pending', 'paid', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
