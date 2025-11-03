<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique(); // AD-2025-001
            $table->foreignId('advertiser_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('placement_id')->constrained('advertisement_placements');

            // Informations campagne
            $table->string('name'); // Nom interne
            $table->text('description')->nullable();

            // Contenu
            $table->enum('content_type', ['image', 'video', 'html'])->default('image');
            $table->string('image_path')->nullable();
            // Dans ta migration advertisements
            $table->string('video_path')->nullable(); // Après video_url
            $table->string('video_url')->nullable();
            $table->text('html_content')->nullable();
            $table->string('headline')->nullable(); // Titre
            $table->text('caption')->nullable(); // Texte accompagnement
            $table->string('cta_text')->nullable(); // Texte bouton : "En savoir plus"
            $table->string('target_url'); // URL de destination
            $table->boolean('open_new_tab')->default(true);

            // Période
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->boolean('is_permanent')->default(false);

            // Budget et facturation
            $table->decimal('budget', 10, 2)->default(0);
            $table->decimal('spent', 10, 2)->default(0);
            $table->decimal('daily_budget', 10, 2)->nullable();

            // Ciblage
            $table->json('target_rubriques')->nullable(); // IDs rubriques
            $table->json('target_pages')->nullable(); // home, article, etc.
            $table->json('target_devices')->nullable(); // mobile, desktop
            $table->json('target_cities')->nullable();
            $table->json('target_days')->nullable(); // Jours de la semaine
            $table->time('target_time_start')->nullable();
            $table->time('target_time_end')->nullable();

            // Limites
            $table->integer('max_impressions')->nullable();
            $table->integer('max_clicks')->nullable();
            $table->integer('max_daily_impressions')->nullable();
            $table->integer('max_daily_clicks')->nullable();

            // Statistiques
            $table->bigInteger('impressions_count')->default(0);
            $table->bigInteger('clicks_count')->default(0);
            $table->decimal('ctr', 5, 2)->default(0); // Click Through Rate

            // Statut workflow
            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'active',
                'paused',
                'completed',
                'rejected',
                'expired'
            ])->default('draft');

            // Validation
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users');

            // Priorité affichage
            $table->integer('priority')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'start_date', 'end_date']);
            $table->index(['advertiser_id', 'status']);
            $table->index('placement_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
