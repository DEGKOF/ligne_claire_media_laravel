<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('telephone');
            $table->enum('poste', ['journaliste', 'redacteur']);
            $table->string('cv_path'); // Chemin du CV
            $table->text('lettre_motivation_texte')->nullable(); // Lettre écrite
            $table->string('lettre_motivation_path')->nullable(); // Lettre uploadée
            $table->enum('statut', ['en_attente', 'examinee', 'acceptee', 'refusee'])->default('en_attente');
            $table->text('notes_admin')->nullable(); // Notes de l'admin
            $table->timestamp('date_examen')->nullable();
            $table->timestamps();

            // Index pour optimiser les recherches
            $table->index('email');
            $table->index('poste');
            $table->index('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};
