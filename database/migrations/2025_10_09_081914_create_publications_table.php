<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Auteur
            $table->foreignId('rubrique_id')->constrained()->onDelete('restrict'); // Rubrique obligatoire
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Résumé court
            $table->longText('content')->nullable(); // Contenu complet

            // Type de contenu
            $table->enum('type', ['article', 'direct', 'rediffusion', 'video_courte', 'lien_externe'])
                  ->default('article');

            // Médias
            $table->string('featured_image')->nullable();
            $table->string('video_url')->nullable(); // URL vidéo (YouTube, etc.)
            $table->string('external_link')->nullable(); // Lien externe
            $table->integer('video_duration')->nullable(); // Durée en secondes

            // Statut et visibilité
            $table->enum('status', ['draft', 'published', 'hidden', 'archived'])
                  ->default('draft');
            $table->boolean('is_featured')->default(false); // Article à la une
            $table->boolean('is_breaking')->default(false); // Flash info
            $table->timestamp('published_at')->nullable();

            // Statistiques
            $table->bigInteger('views_count')->default(0);
            $table->bigInteger('comments_count')->default(0);
            $table->bigInteger('shares_count')->default(0);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index pour performance
            $table->index(['status', 'published_at']);
            $table->index('rubrique_id');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
