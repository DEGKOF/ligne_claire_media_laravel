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
        Schema::create('editos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Auteur
            $table->string('title'); // Titre de l'édito
            $table->string('slug')->unique(); // URL-friendly
            $table->text('excerpt')->nullable(); // Extrait/résumé court
            $table->longText('content'); // Contenu formaté avec CKEditor
            $table->string('cover_image')->nullable(); // Image de couverture (optionnelle)
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable(); // Date de publication
            $table->timestamps();
            $table->softDeletes();

            // Index pour améliorer les performances
            $table->index('status');
            $table->index('published_at');
            $table->index('user_id');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editos');
    }
};
