<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rubriques', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nom de la rubrique
            $table->string('slug')->unique(); // URL-friendly
            $table->text('description')->nullable();
            $table->integer('order')->default(0); // Ordre d'affichage
            $table->boolean('is_active')->default(true);
            $table->string('icon')->nullable(); // Icône pour l'affichage
            $table->string('color')->nullable(); // Couleur associée
            $table->bigInteger('views_count')->default(0); // Compteur de vues
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rubriques');
    }
};
