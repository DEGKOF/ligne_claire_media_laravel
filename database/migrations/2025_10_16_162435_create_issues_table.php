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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_number')->unique(); // Ex: 5475
            $table->string('title'); // Ex: "Mercredi 15 Octobre 2025"
            $table->string('cover_image')->nullable(); // Chemin vers l'image de couverture
            $table->text('description')->nullable(); // Description du contenu
            $table->timestamp('published_at'); // Date de publication
            $table->decimal('price', 8, 2)->default(1.80); // Prix version papier
            $table->decimal('digital_price', 8, 2)->default(1.50); // Prix version numérique
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('stock_quantity')->default(0); // Stock disponible pour version papier
            $table->string('pdf_file')->nullable(); // Fichier PDF pour version numérique
            $table->timestamps();
            $table->softDeletes();

            // Index pour améliorer les performances
            $table->index('published_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issues');
    }
};
