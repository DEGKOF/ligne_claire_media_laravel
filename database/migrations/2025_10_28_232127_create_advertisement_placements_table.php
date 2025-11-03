<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisement_placements', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Bannière Haut, Sidebar, etc.
            $table->string('slug')->unique();
            $table->string('code')->unique(); // banner_top, sidebar, etc.
            $table->text('description')->nullable();

            // Dimensions
            $table->integer('width')->nullable(); // en pixels
            $table->integer('height')->nullable();
            $table->string('format')->nullable(); // 728x90, 300x250, etc.

            // Tarification
            $table->decimal('price_per_day', 10, 2)->default(0);
            $table->decimal('price_per_impression', 10, 4)->default(0); // CPM
            $table->decimal('price_per_click', 10, 2)->default(0); // CPC

            // Configuration
            $table->enum('billing_type', ['flat', 'cpm', 'cpc'])->default('flat');
            $table->integer('max_ads')->default(1); // Nb max de pubs simultanées
            $table->integer('rotation_interval')->default(5); // Rotation en secondes
            $table->integer('priority')->default(0);

            // Restrictions
            $table->json('allowed_formats')->nullable(); // ['image', 'video', 'html']
            $table->integer('max_file_size')->default(2048); // En Ko
            $table->json('allowed_extensions')->nullable(); // ['jpg', 'png', 'gif']

            // Visibilité
            $table->boolean('is_active')->default(true);
            $table->boolean('show_on_mobile')->default(true);
            $table->boolean('show_on_desktop')->default(true);

            // Pages
            $table->json('pages')->nullable(); // Où afficher : home, article, rubrique, etc.

            $table->timestamps();

            $table->index(['is_active', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisement_placements');
    }
};
